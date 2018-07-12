<?php

namespace Model\CentovaCast;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Track extends Model {
	protected $connection = 'centova';
	protected $table      = 'tracks';
	protected $primaryKey = 'id';

	public $timestamps = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function artist(): BelongsTo {
	    return $this->belongsTo(Artist::class, 'artistid');
	}
}
