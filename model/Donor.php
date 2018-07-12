<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model {
	protected $connection = 'panel';
	protected $table      = 'donor';
	protected $primaryKey = 'donor_id';
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function donations(): HasMany {
	    return $this->hasMany(Donation::class, 'donor_id');
	}
}
