<?php

namespace Service\IceCast;

use Dto\IceCast\IceCastStreamDto;
use Exception\ApiCallFailedException;
use Exception\InvalidHttpMethodException;
use Exception\InvalidMountpointException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Psr\Http\Message\ResponseInterface;

class IceCastDataClient {
	/**
	 * @var array
	 */
	protected $mountpointApiUrls;

	/**
	 * @var array
	 */
	protected $mountpointConfigs;

	/**
	 * @param array $config
	 */
	public function __construct(array $config) {
		$this->mountpointApiUrls = $config['api'];
		$this->mountpointConfigs = $config['mountpoints'];
	}

	/**
	 * @param string $mountpoint
	 *
	 * @return \Dto\IceCast\IceCastStreamDto
	 */
	public function fetchMountpoint(string $mountpoint): IceCastStreamDto {
		if (!array_key_exists($mountpoint, $this->mountpointApiUrls)) {
			throw new InvalidMountpointException(
				sprintf(
					'There is no mountpoint with the name "%s"',
					$mountpoint
				)
			);
		}

		$url = $this->mountpointApiUrls[$mountpoint];

		$mountpointApiResult = $this->callApi($url, 200)
			->getBody()
			->getContents();

		$iceCastStreamDto = $this->getIceCastStreamDtoFromMountpointApiResult($mountpointApiResult);

		return $iceCastStreamDto;
	}

	/**
	 * @param string $song
	 * @param string $mountpoint
	 *
	 * @return void
	 */
	public function updateMetadataSongForMountpoint(string $song, string $mountpoint): void {
		$iceCastMetadataApiConfig = $this->mountpointConfigs[$mountpoint];

		$url                       = $iceCastMetadataApiConfig['url'];
		$username                  = $iceCastMetadataApiConfig['username'];
		$password                  = $iceCastMetadataApiConfig['password'];
		$mountpointsMetadataUpdate = $iceCastMetadataApiConfig['metadata_update_mountpoints'];

		$url = $url . 'admin/metadata.xsl';

		foreach ($mountpointsMetadataUpdate as $mountpoint) {
			$options = $this->buildOptionsForMetadataSongUpdate(
				$username,
				$password,
				$song,
				$mountpoint
			);

			try {
				$this->callApi($url, 200, 'GET', $options);
			}
			catch (ApiCallFailedException $exception) {}
		}
	}

	/**
	 * @param string $result
	 *
	 * @return \Dto\IceCast\IceCastStreamDto
	 */
	protected function getIceCastStreamDtoFromMountpointApiResult(string $result): IceCastStreamDto {
		$iceCastStreamData = json_decode($result, true);

		$iceCastStreamDtoTransformer = new IceCastStreamDtoTransformer();

		return $iceCastStreamDtoTransformer->arrayToDto($iceCastStreamData['icestats']);
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @param string $song
	 * @param string $mountpoint
	 *
	 * @return array
	 */
	protected function buildOptionsForMetadataSongUpdate(
		string $username,
		string $password,
		string $song,
		string $mountpoint
	): array {
		return [
			'auth' => [
				$username,
				$password
			],
			'query' => [
				'mode' => 'updinfo',
				'charset' => 'UTF-8',
				'mount' => '/' . $mountpoint,
				'song' => $song
			]
		];
	}

	/**
	 * @param string $url
	 * @param int $expectedStatusCode
	 * @param string $method
	 * @param array $options
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	protected function callApi(
		string $url,
		int $expectedStatusCode,
		string $method = 'GET',
		array $options = []
	): ResponseInterface {
		$client = new Client();

		$response = null;

		try {
			switch ($method) {
				case 'GET':
					$response = $client->get($url, $options);
					break;

				case 'POST':
					$response = $client->post($url, $options);
					break;

				default:
					throw new InvalidHttpMethodException(
						sprintf(
							'"%s" is not a valid HTTP method',
							$method
						)
					);
					break;
			}

			if ($response->getStatusCode() !== $expectedStatusCode) {
				throw new ApiCallFailedException(
					sprintf(
						'Api call to "%s" failed with status code "%s" expected "%s"',
						$url,
						$response->getStatusCode(),
						$expectedStatusCode
					)
				);
			}
		}
		catch (RequestException $exception) {
			throw new ApiCallFailedException(
				sprintf(
					'Api call to "%s" failed with status code "%s" expected "%s"',
					$url,
					$exception->getCode(),
					$expectedStatusCode
				)
			);
		}

		return $response;
	}
}
