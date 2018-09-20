<?php

namespace BRG\Panel\Model\CentovaCast;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model {
	protected $connection = 'centova';
	protected $table      = 'track_artists';
	protected $primaryKey = 'id';

	/**
	 * @return HasMany
	 */
	public function tracks(): HasMany {
	    return $this->hasMany(Track::class, 'artistid');
	}
}
