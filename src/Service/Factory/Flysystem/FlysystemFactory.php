<?php

namespace BRG\Panel\Service\Factory\Flysystem;

use BRG\Panel\Exception\MissingAdapterArgumentException;
use BRG\Panel\Exception\UnknownFlysystemAdapterClassNameException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\PhpseclibV3\SftpAdapter;
use League\Flysystem\PhpseclibV3\SftpConnectionProvider;

class FlysystemFactory {
	/**
	 * @param array $config
	 *
	 * @return Filesystem
	 */
	public static function create(array $config): Filesystem {
		$flysystemFactory = new FlysystemFactory();

		$adapter = $flysystemFactory->createAdapter($config['adapter'], $config['arguments']);

		return $flysystemFactory->instantiateFilesystem($adapter, $config['config']);
	}

	/**
	 * @param string $adapterClassName
	 * @param array $arguments
	 *
	 * @return FilesystemAdapter
	 */
	private function createAdapter(string $adapterClassName, array $arguments): FilesystemAdapter {
		switch ($adapterClassName) {
			case LocalFilesystemAdapter::class:
				return $this->instantiateLocalAdapter($arguments);

			case SftpAdapter::class:
				return $this->instantiateSftpAdapter($arguments);

			default:
				throw new UnknownFlysystemAdapterClassNameException(
					sprintf(
						'The class "%s" is not a supported Flysystem Adapter',
						$adapterClassName
					)
				);
		}
	}

	/**
	 * @param array $arguments
	 *
	 * @return LocalFilesystemAdapter
	 */
	private function instantiateLocalAdapter(array $arguments): LocalFilesystemAdapter {
		if (!isset($arguments['path'])) {
			throw new MissingAdapterArgumentException('The Local adapter needs the "path" argument');
		}

		return new LocalFilesystemAdapter($arguments['path']);
	}

	/**
	 * @param array $arguments
	 *
	 * @return SftpAdapter
	 */
	private function instantiateSftpAdapter(array $arguments): SftpAdapter {
		if (!isset($arguments['host'])) {
			throw new MissingAdapterArgumentException('The SFTP adapter needs the "host" argument');
		}

		if (!isset($arguments['username'])) {
			throw new MissingAdapterArgumentException('The SFTP adapter needs the "username" argument');
		}

		if (!isset($arguments['private_key']) && !isset($arguments['password'])) {
			throw new MissingAdapterArgumentException('The SFTP adapter needs the "password" or "private_key" argument');
		}

		$config = [
			'host' => $arguments['host'],
			'username' => $arguments['username']
		];

		if (isset($arguments['private_key'])) {
			$config['privateKey'] = $arguments['private_key'];
		}
		else {
			$config['password'] = $arguments['password'];
		}

		if (isset($arguments['port'])) {
			$config['port'] = $arguments['port'];
		}

		if (isset($arguments['timeout'])) {
			$config['timeout'] = $arguments['timeout'];
		}

		return new SftpAdapter(
			SftpConnectionProvider::fromArray($config),
			$arguments['root'] ?? ''
		);
	}

	/**
	 * @param FilesystemAdapter $adapter
	 * @param array $config
	 *
	 * @return Filesystem
	 */
	private function instantiateFilesystem(FilesystemAdapter $adapter, array $config = []): Filesystem {
		return new Filesystem($adapter, $config);
	}
}
