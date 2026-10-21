<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;

class History extends Model {
	protected $connection = 'panel';
	protected $table      = 'history';
	protected $primaryKey = 'history_id';
}
