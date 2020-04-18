<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {
	use SoftDeletes;

	public const TABLE_NAME = 'user';
	public const PRIMARY_KEY = 'user_id';

	protected $connection = 'panel';
	protected $table      = self::TABLE_NAME;
	protected $primaryKey = self::PRIMARY_KEY;
	protected $dates      = ['created_at', 'updated_at', 'deleted_at'];

	/**
	 * @return HasMany
	 */
	public function authenticationTokens(): HasMany {
	    return $this->hasMany(AuthenticationToken::class, 'user_id');
	}

	/**
	 * @return BelongsToMany
	 */
	public function roles(): BelongsToMany {
		return $this->belongsToMany(Role::class, RoleUser::TABLE_NAME, User::PRIMARY_KEY, Role::PRIMARY_KEY)
			->using(RoleUser::class)
			->withTimestamps()
			->withPivot([
				'role_user_id'
			]);
	}
}
