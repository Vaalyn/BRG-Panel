<?php

namespace BRG\Panel\Model\Manager;

use BRG\Panel\Model\History;
use Illuminate\Database\Eloquent\Builder;

class HistoryModelManager {
	/**
	 * @param string|null $datePlayedStart
	 * @param string|null $datePlayedEnd
	 * @param string|null $timePlayedStart
	 * @param string|null $timePlayedEnd
	 * @param string|null $title
	 * @param string|null $artist
	 *
	 * @return Builder
	 */
	public function createFetchHistoryQuery(
		?string $datePlayedStart = null,
		?string $datePlayedEnd = null,
		?string $timePlayedStart = null,
		?string $timePlayedEnd = null,
		?string $title = null,
		?string $artist = null
	): Builder {
		$historyQuery = History::query();

		if ($datePlayedStart) {
			$historyQuery->where('date_played', '>=', $datePlayedStart);
		}

		if ($datePlayedEnd) {
			$historyQuery->where('date_played', '<=', $datePlayedEnd);
		}

		if ($timePlayedStart) {
			$historyQuery->where('time_played', '>=', $timePlayedStart);
		}

		if ($timePlayedEnd) {
			$historyQuery->where('time_played', '<=', $timePlayedEnd);
		}

		if ($title) {
			$historyQuery->where('title', 'LIKE', $title);
		}

		if ($artist) {
			$historyQuery->where('artist', 'LIKE', $artist);
		}

		return $historyQuery
			->orderBy('date_played', 'DESC')
			->orderBy('time_played', 'DESC');
	}
}
