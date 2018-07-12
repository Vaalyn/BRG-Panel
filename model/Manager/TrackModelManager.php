<?php

namespace Model\Manager;

use Illuminate\Database\Eloquent\Collection;
use Model\Track;

class TrackModelManager {
	/**
	 * @param int $id
	 * @param bool $onlyAutoDjTracks
	 *
	 * @return \Model\Track|null
	 */
	public function findTrackById(int $id, bool $onlyAutoDjTracks = false): ?Track {
		$trackQuery = Track::with('artist');

		if ($onlyAutoDjTracks) {
			$trackQuery->where('autodj', '=', $onlyAutoDjTracks);
		}

		return $trackQuery->find($id);
	}

	/**
	 * @param string $title
	 * @param string $artist
	 *
	 * @return \Model\Track|null
	 */
	public function findTrackByTitleAndArtist(string $title, string $artist): ?Track {
		$trackQuery = Track::where('title', '=', $title);

		$trackQuery->whereHas('artist', function($query) use($artist) {
			$query->where('name', '=', $artist);
		});

		return $trackQuery->first();
	}

	/**
	 * @param string|null $title
	 * @param string|null $artist
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function searchTracksByTitleAndArtist(?string $title = null, ?string $artist = null): Collection {
		$tracksQuery = Track::with('artist');

		if ($title !== null) {
			$tracksQuery->where('title', 'LIKE', '%' . $title . '%');
		}

		if ($artist !== null) {
			$tracksQuery->whereHas('artist', function($query) use($artist) {
				$query->where('name', 'LIKE', '%' . $artist . '%');
			});
		}

		return $tracksQuery->get();
	}

	/**
	 * @param string|null $title
	 * @param string|null $artist
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function searchAutoDjTracksByTitleAndArtist(?string $title = null, ?string $artist = null): Collection {
		$tracksQuery = Track::with('artist')->where('autodj', '=', true);

		if ($title !== null) {
			$tracksQuery->where('title', 'LIKE', '%' . $title . '%');
		}

		if ($artist !== null) {
			$tracksQuery->whereHas('artist', function($query) use($artist) {
				$query->where('name', 'LIKE', '%' . $artist . '%');
			});
		}

		return $tracksQuery->get();
	}

	/**
	 * @param string $title
	 * @param int $artistId
	 * @param bool $isAutoDjTrack
	 * @param int|null $length
	 * @param string|null $url
	 * @param string|null $pathname
	 * @param bool|null $ignoreVotes
	 *
	 * @return \Model\Track
	 */
	public function createTrack(
		string $title,
		int $artistId,
		bool $isAutoDjTrack,
		int $length = null,
		string $url = null,
		string $pathname = null,
		bool $ignoreVotes = null
	): Track {
		$track = Track::where([
			['title', '=', $title],
			['artist_id', '=', $artistId]
		])->first();

		if (!isset($track)) {
			$track = new Track();
			$track->pathname     = $pathname ?? '';
			$track->length       = $length ?? 0;
			$track->url          = $url ?? '';
			$track->ignore_votes = $ignoreVotes ?? false;
		}

		$track->pathname     = $pathname ?? $track->pathname;
		$track->title        = $title;
		$track->length       = $length ?? $track->length;
		$track->url          = $url ?? $track->url;
		$track->artist_id    = $artistId;
		$track->autodj       = $isAutoDjTrack;
		$track->ignore_votes = $ignoreVotes ?? $track->ignore_votes;
		$track->save();

		return $track;
	}
}
