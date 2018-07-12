<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model {
	protected $connection = 'panel';
	protected $table      = 'stream';
	protected $primaryKey = 'stream_id';
	protected $dates      = ['created_at', 'updated_at'];
}
