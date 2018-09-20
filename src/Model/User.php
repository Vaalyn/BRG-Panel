<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {
	use SoftDeletes;

	protected $connection = 'panel';
	protected $table      = 'user';
	protected $primaryKey = 'user_id';
	protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

	/**
	 * @return HasMany
	 */
	public function authTokens(): HasMany {
	    return $this->hasMany(AuthToken::class, 'user_id');
	}
}