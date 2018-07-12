<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {
	protected $connection = 'panel';
	protected $table      = 'status';
	protected $primaryKey = 'status_id';
	protected $dates      = ['created_at', 'updated_at'];
}
