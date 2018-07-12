<?php

namespace Service\IceCast;

use Dto\IceCast\IceCastSourceDto;

class IceCastSourceDtoTransformer {
	/**
	 * @param array $iceCastSource
	 *
	 * @return \Dto\IceCast\IceCastSourceDto
	 */
	public function arrayToDto(array $iceCastSource): IceCastSourceDto {
		$iceCastSourceDto = new IceCastSourceDto(
			$iceCastSource['audio_info']          ?? '',
			(int) ($iceCastSource['bitrate']      ?? 0),
			(int) ($iceCastSource['channels']     ?? 0),
			$iceCastSource['genre']               ?? '',
			(int) ($iceCastSource['listener_peak'] ?? 0),
			(int) ($iceCastSource['listeners']     ?? 0),
			$iceCastSource['listenurl']           ?? '',
			(int) ($iceCastSource['samplerate']    ?? 0),
			$iceCastSource['server_description']  ?? '',
			$iceCastSource['server_name']         ?? '',
			$iceCastSource['server_type']         ?? '',
			$iceCastSource['server_url']          ?? '',
			$iceCastSource['stream_start']        ?? '',
			$iceCastSource['title']               ?? ''
		);

		return $iceCastSourceDto;
	}
}
