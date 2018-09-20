<?php

namespace BRG\Panel\Service\IceCast;

use BRG\Panel\Dto\IceCast\IceCastStreamDto;

class IceCastStreamDtoTransformer {
	/**
	 * @param array $iceCastStream
	 *
	 * @return IceCastStreamDto
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
