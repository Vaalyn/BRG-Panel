<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BestOfVote extends Model {
	protected $connection = 'panel';
	protected $table      = 'best_of_vote';
	protected $primaryKey = 'best_of_vote_id';
	protected $dates      = ['created_at', 'updated_at'];

	public $incrementing = false;
}
