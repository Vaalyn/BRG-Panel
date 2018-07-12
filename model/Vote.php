<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model {
	protected $connection = 'panel';
	protected $table      = 'vote';
	protected $primaryKey = 'vote_id';
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function track(): BelongsTo {
	    return $this->belongsTo(Track::class, 'track_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function voter(): BelongsTo {
	    return $this->belongsTo(Voter::class, 'voter_id');
	}
}
