<?php

namespace BRG\Panel\Model\Manager;

use BRG\Panel\Model\Artist;

class ArtistModelManager {
	/**
	 * @param string $artistName
	 *
	 * @return Artist
	 */
	public function createArtist(string $artistName): Artist {
		$artist = Artist::where('name', '=', $artistName)->first();

		if (!isset($artist)) {
			$artist = new Artist();
		}

		$artist->name = $artistName;
		$artist->save();

		return $artist;
	}
}
