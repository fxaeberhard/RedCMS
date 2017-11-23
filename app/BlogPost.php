<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model {

	protected $guarded = ['_token'];

	public function blog() {
		return $this->belongsTo('App\Blog');
	}

	public function comments() {
		return $this->hasMany('App\BlogComment')->orderBy('created_at');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}
}
