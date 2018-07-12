<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voter extends Model {
	protected $connection = 'panel';
	protected $table      = 'voter';
	protected $primaryKey = 'voter_id';
	protected $dates      = ['created_at', 'updated_at'];

	public $incrementing = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function votes(): HasMany {
	    return $this->hasMany(Vote::class, 'voter_id');
	}
}
