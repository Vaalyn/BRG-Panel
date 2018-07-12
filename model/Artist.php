<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model {
	protected $connection = 'panel';
	protected $table      = 'artist';
	protected $primaryKey = 'artist_id';
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function tracks(): HasMany {
	    return $this->hasMany(Track::class, 'artist_id');
	}
}
