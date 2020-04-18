<?php

declare(strict_types=1);

use BRG\Panel\Console\Command\GenerateTranslationsCommand;

return [
	new GenerateTranslationsCommand(
		$container->renderer->getTemplatePath(),
		__DIR__ . '/../src'
	),
];
