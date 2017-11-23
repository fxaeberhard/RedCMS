<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	protected $guarded = ['_token'];

	// public function users() {
	// 	return $this->hasMany('App\User');
	// }

}
