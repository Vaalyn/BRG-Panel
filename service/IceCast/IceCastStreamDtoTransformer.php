<?php

namespace Service\IceCast;

use Dto\IceCast\IceCastStreamDto;

class IceCastStreamDtoTransformer {
	/**
	 * @param array $iceCastStream
	 *
	 * @return \Dto\IceCast\IceCastStreamDto
	 */
	public function arrayToDto(array $iceCastStream): IceCastStreamDto {
		$iceCastStreamDto = new IceCastStreamDto(
			$iceCastStream['host'] ?? '',
			[]
		);

		$iceCastSourceDtoTransformer = new IceCastSourceDtoTransformer();

		foreach ($iceCastStream['source'] as $source) {
			$iceCastStreamDto->addSource(
				$iceCastSourceDtoTransformer->arrayToDto($source)
			);
		}

		return $iceCastStreamDto;
	}
}
