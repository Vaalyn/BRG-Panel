<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class History extends Model {
	protected $connection = 'panel';
	protected $table      = 'history';
	protected $primaryKey = 'history_id';
	protected $dates      = ['created_at', 'updated_at'];
}
