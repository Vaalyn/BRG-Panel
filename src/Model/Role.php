<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model {
	public const TABLE_NAME = 'role';
	public const PRIMARY_KEY = 'role_id';

	protected $connection = 'panel';
	protected $table      = self::TABLE_NAME;
	protected $primaryKey = self::PRIMARY_KEY;
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return BelongsToMany
	 */
	public function users(): BelongsToMany {
		return $this->belongsToMany(User::class, RoleUser::TABLE_NAME, Role::PRIMARY_KEY, User::PRIMARY_KEY)
			->using(RoleUser::class)
			->withTimestamps()
			->withPivot([
				'role_user_id'
			]);
	}
}
