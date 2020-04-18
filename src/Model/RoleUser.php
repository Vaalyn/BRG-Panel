<?php

declare(strict_types = 1);

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleUser extends Pivot {
	public const TABLE_NAME  = 'role_user';
	public const PRIMARY_KEY = 'role_user_id';

	protected $table      = self::TABLE_NAME;
	protected $primaryKey = self::PRIMARY_KEY;
	protected $dates      = ['created_at', 'updated_at'];

	/**
	 * @return BelongsTo
	 */
	public function role(): BelongsTo {
		return $this->belongsTo(Role::class, 'role_id');
	}

	/**
	 * @return BelongsTo
	 */
	public function post(): BelongsTo {
		return $this->belongsTo(User::class, 'user_id');
	}
}
