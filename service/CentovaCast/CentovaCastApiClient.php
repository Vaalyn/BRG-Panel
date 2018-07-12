<?php

namespace Service\CentovaCast;

use Dto\CentovaCast\CentovaCastTrackDto;
use Exception\InvalidCentovaCastApiXmlException;
use GuzzleHttp\Client;
use SimpleXMLElement;

class CentovaCastApiClient {
	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var string
	 */
	protected $password;

	/**
	 * @var string
	 */
	protected $rpcUrl;

	/**
	 * @param array $config
	 */
	public function __construct(array $config) {
		$this->url      = $config['url'];
		$this->username = $config['username'];
		$this->password = $config['password'];
		$this->rpcUrl   = $config['rpc_url'];
	}

	/**
	 * @param string $mountpoint
	 *
	 * @return array|object|string
	 */
	public function fetchSongHistory(string $mountpoint) {
		$requestString = sprintf(
			'<request class="server" method="getsongs">
				<mountpoints>/%s</mountpoints>',
			$mountpoint
		);

		$historyXmlElement = $this->callApi($requestString);

		$tracks = [];

		foreach ($historyXmlElement->children() as $data) {
			foreach ($data->data->songs->row as $row => $value) {
				$track = new CentovaCastTrackDto(
					(int) $value->time,
					$value->track->raw->artist,
					$value->track->raw->title
				);

				array_push($tracks, $track);
			}
		}

		return $tracks;
	}

	/**
	 * Return TRUE on succesful request and FALSE on failure
	 *
	 * @param string $title
	 * @param string $artist
	 * @param string $nickname
	 *
	 * @return bool
	 */
	public function requestSong(string $title, string $artist, string $nickname): bool {
		$client = new Client();

		$options = [
			'query' => [
				'callback' => '',
				'm' => 'request.submit',
				'username' => 'brg_main',
				'charset' => '',
				'artist' => $artist,
				'title' => $title,
				'sender' => $nickname,
				'email' => 'technik@bronyradiogermany.com',
				'dedi' => '',
				'brg_main' => '',
				'_=' => time()
			]
		];

		$response = $client->get($this->rpcUrl, $options);

		if ($response->getStatusCode() !== 200) {
			return false;
		}

		$jsonResponseContents = $response->getBody()->getContents();

		$deserializedJsonResponse = json_decode($jsonResponseContents);

		if (!isset($deserializedJsonResponse->type) || $deserializedJsonResponse->type !== 'result') {
			return false;
		}

		return true;
	}

	/**
	 * @param string $requestString
	 *
	 * @return SimpleXMLElement
	 */
	protected function callApi(string $requestString): SimpleXMLElement {
		$client = new Client();

		$call = sprintf(
			'<?xml version="1.0" encoding="UTF-8"?>
			<centovacast>
				%s
					<password>%s</password>
					<username>%s</username>
				</request>
			</centovacast>',
			$requestString,
			$this->password,
			$this->username
		);

		$options = [
			'content-type' => 'text/xml; charset=UTF-8',
			'body' => $call
		];

		$response = $client->post(
			$this->url,
			$options
		);

		$responseContents = $response->getBody()->getContents();

		return $this->deserializeResponseXml($responseContents);
	}

	/**
	 * @param string $response
	 *
	 * @return SimpleXMLElement
	 */
	protected function deserializeResponseXml(string $response): SimpleXMLElement {
		$xmlString = html_entity_decode($response);
		$xmlString = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xmlString);

		$xmlElement = simplexml_load_string($xmlString);

		if ($xmlElement === false) {
			throw new InvalidCentovaCastApiXmlException(sprintf(
				'An error occured while parsing the following XML response: %s',
				$response
			));
		}

		return $xmlElement;
	}
}
