<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoinEvent extends Model {
	protected $connection = 'panel';
	protected $table      = 'coin_event';
	protected $primaryKey = 'coin_id';
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return BelongsTo
	 */
	public function communityUser(): BelongsTo {
	    return $this->belongsTo(CommunityUser::class, 'community_user_id');
	}
}
