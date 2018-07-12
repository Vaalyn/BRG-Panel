<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityUser extends Model {
	protected $connection = 'panel';
	protected $table      = 'community_user';
	protected $primaryKey = 'community_user_id';
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function coinEvents(): HasMany {
	    return $this->hasMany(CoinEvent::class, 'community_user_id');
	}
}
