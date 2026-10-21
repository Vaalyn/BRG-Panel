<?php

namespace BRG\Panel\Model;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model {
	protected $connection = 'panel';
	protected $table      = 'stream';
	protected $primaryKey = 'stream_id';
}
