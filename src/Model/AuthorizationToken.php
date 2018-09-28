<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorizationToken extends Model {
	protected $connection = 'panel';
	protected $table      = 'authorization_token';
	protected $primaryKey = 'authorization_token_id';
	protected $dates      = ['created_at', 'updated_at'];

	public $incrementing = false;

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * @return HasMany
	 */
	public function authorizedRoutes(): HasMany {
	    return $this->hasMany(AuthorizedRoute::class, 'authorization_token_id');
	}
}
