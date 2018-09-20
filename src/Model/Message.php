<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model {
	use SoftDeletes;

	protected $connection = 'panel';
	protected $table      = 'message';
	protected $primaryKey = 'message_id';
	protected $dates      = ['created_at', 'updated_at', 'deleted_at'];
}
