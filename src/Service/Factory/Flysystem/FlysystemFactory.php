<?php

namespace BRG\Panel\Service\Factory\Flysystem;

use BRG\Panel\Exception\MissingAdapterArgumentException;
use BRG\Panel\Exception\UnknownFlysystemAdapterClassNameException;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

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
	 * @return AdapterInterface
	 */
	private function createAdapter(string $adapterClassName, array $arguments): AdapterInterface {
		switch ($adapterClassName) {
			case 'League\Flysystem\Adapter\Local':
				return $this->instantiateLocalAdapter($arguments);

			case 'League\Flysystem\Sftp\SftpAdapter':
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
	 * @return Local
	 */
	private function instantiateLocalAdapter(array $arguments): Local {
		if (!isset($arguments['path'])) {
			throw new MissingAdapterArgumentException('The Local adapter needs the "path" argument');
		}

		return new Local($arguments['path']);
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

		if (isset($arguments['root'])) {
			$config['root'] = $arguments['root'];
		}

		if (isset($arguments['timeout'])) {
			$config['timeout'] = $arguments['timeout'];
		}

		return new SftpAdapter($config);
	}

	/**
	 * @param AdapterInterface $adapter
	 * @param array $config
	 *
	 * @return Filesystem
	 */
	private function instantiateFilesystem(AdapterInterface $adapter, array $config = []): Filesystem {
		return new Filesystem($adapter, $config);
	}
}
