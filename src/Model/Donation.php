<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model {
	use SoftDeletes;

	protected $connection = 'panel';
	protected $table      = 'donation';
	protected $primaryKey = 'donation_id';

	/**
	 * @return BelongsTo
	 */
	public function donor(): BelongsTo {
	    return $this->belongsTo(Donor::class, 'donor_id');
	}
}
