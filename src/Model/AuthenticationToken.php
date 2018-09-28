<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthenticationToken extends Model {
	use SoftDeletes;

	protected $connection = 'panel';
	protected $table      = 'authentication_token';
	protected $primaryKey = 'authentication_token_id';
	protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

	public $incrementing = false;

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'user_id');
	}
}
