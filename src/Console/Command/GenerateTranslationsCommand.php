<?php

declare(strict_types=1);

namespace BRG\Panel\Console\Command;

use Gettext\Generator\PoGenerator;
use Gettext\Scanner\PhpScanner;
use Gettext\Translations;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateTranslationsCommand extends Command {
	protected static $defaultName = 'brg:translations:generate';

	/**
	 * @var string
	 */
	protected $templatePath;

	/**
	 * @var string
	 */
	protected $sourceCodePath;

	public function __construct(string $templatePath, string $sourceCodePath) {
		$this->templatePath = $templatePath;
		$this->sourceCodePath = $sourceCodePath;

		parent::__construct();
	}

    protected function configure() {
        $this->setDescription('Generate translations file')
        	->setHelp('Generates the german translations file for all translatable strings in the templates');
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int {
		$symfonyOutputStyle = new SymfonyStyle($input, $output);

		$symfonyOutputStyle->writeln('Scanning files for translatable strings...');

		$phpScanner = new PhpScanner(
			Translations::create('frontend', 'en'),
			Translations::create('frontend', 'de')
		);
		$phpScanner->setDefaultDomain('frontend');
		$phpScanner->ignoreInvalidFunctions(true);

		$phpScanner = $this->scanTemplateFiles(
			$this->templatePath,
			$symfonyOutputStyle,
			$phpScanner
		);

		$phpScanner = $this->scanSourceCodeFiles(
			$this->sourceCodePath,
			$symfonyOutputStyle,
			$phpScanner
		);

		$symfonyOutputStyle->writeln('Writing translations to file...');

		$this->writeTranslations(
			$phpScanner->getTranslations()
		);

		$symfonyOutputStyle->writeln('Done');

        return 0;
	}

	protected function scanTemplateFiles(
		string $templatesPath,
		SymfonyStyle $symfonyOutputStyle,
		PhpScanner $phpScanner
	): PhpScanner {
		$regexIteratorTemplates = $this->buildRecursiveRegexIteratorForPhpFiles($templatesPath);

		$templateFilesCount = iterator_count($regexIteratorTemplates);

		$symfonyOutputStyle->writeln(sprintf(
			'Scanning %s templates...',
			$templateFilesCount
		));

		$symfonyOutputStyle->progressStart($templateFilesCount);

		foreach ($regexIteratorTemplates as $path_match) {
			$path = $path_match[0];
			$phpScanner->scanFile($path);

			$symfonyOutputStyle->progressAdvance();
		}

		$symfonyOutputStyle->progressFinish();

		$symfonyOutputStyle->writeln('Done');

		return $phpScanner;
	}

	protected function scanSourceCodeFiles(
		string $sourceCodePath,
		SymfonyStyle $symfonyOutputStyle,
		PhpScanner $phpScanner
	): PhpScanner {
		$regexIteratorSourceCodeFiles = $this->buildRecursiveRegexIteratorForPhpFiles($sourceCodePath);

		$sourceCodeFilesCount = iterator_count($regexIteratorSourceCodeFiles);

		$symfonyOutputStyle->writeln(sprintf(
			'Scanning %s source code files...',
			$sourceCodeFilesCount
		));

		$symfonyOutputStyle->progressStart($sourceCodeFilesCount);

		foreach ($regexIteratorSourceCodeFiles as $path_match) {
			$path = $path_match[0];
			$phpScanner->scanFile($path);

			$symfonyOutputStyle->progressAdvance();
		}

		$symfonyOutputStyle->progressFinish();

		$symfonyOutputStyle->writeln('Done');

		return $phpScanner;
	}

	protected function buildRecursiveRegexIteratorForPhpFiles(string $path): RegexIterator {
		$directory = new RecursiveDirectoryIterator($path);
		$iterator = new RecursiveIteratorIterator($directory);

		return new RegexIterator($iterator, '/^.+\.(php)$/i', RecursiveRegexIterator::GET_MATCH);
	}

	/**
	 * @param Translations[] $translations
	 */
	protected function writeTranslations(array $translations): void {
		$poGenerator = new PoGenerator();

		/** @var Translations $translations */
		foreach ($translations as $domain => $translations) {
			$poGenerator->generateFile(
				$translations,
				__DIR__ . '/../../../config/translations/' . $translations->getLanguage() . '/' . $domain . '.po'
			);
		}
	}
}
