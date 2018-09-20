<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthToken extends Model {
	use SoftDeletes;

	protected $connection = 'panel';
	protected $table      = 'auth_token';
	protected $primaryKey = 'auth_token_id';
	protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

	public $incrementing = false;

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'user_id');
	}
}
