<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model {

	protected $guarded = ['_token'];

	public function user() {
		return $this->belongsTo('App\User');
	}
}
