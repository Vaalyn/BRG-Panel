<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorizedRoute extends Model {
	protected $connection = 'panel';
	protected $table      = 'authorized_route';
	protected $primaryKey = 'authorized_route_id';
	protected $dates      = ['created_at', 'updated_at'];

	public $incrementing = false;

	/**
	 * @return BelongsTo
	 */
	public function authorizationToken(): BelongsTo {
		return $this->belongsTo(AuthorizationToken::class, 'authorization_token_id');
	}
}
