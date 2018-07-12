<?php

namespace Model\Manager;

use Model\Artist;

class ArtistModelManager {
	/**
	 * @param string $artistName
	 *
	 * @return \Model\Artist
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
