<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model {
	protected $connection = 'panel';
	protected $table      = 'track';
	protected $primaryKey = 'track_id';
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function artist(): BelongsTo {
	    return $this->belongsTo(Artist::class, 'artist_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function votes(): HasMany {
	    return $this->hasMany(Vote::class, 'track_id');
	}
}
