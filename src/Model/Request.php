<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model {
	use SoftDeletes;

	protected $connection = 'panel';
	protected $table      = 'request';
	protected $primaryKey = 'request_id';
	protected $dates      = ['created_at', 'updated_at', 'deleted_at'];
}
