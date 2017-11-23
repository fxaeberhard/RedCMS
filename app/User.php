<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	// protected $fillable = ['name', 'email', 'password'];
	protected $guarded = ['_token', 'groups'];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	// public function setPasswordAttribute($pass)
	// {
	//     $this->attributes['password'] = bcrypt($pass);
	//     // $this->attributes['password'] = Hash::make($pass);
	// }

	public function groups() {
		return $this->belongsToMany('App\Group');
	}

	public function name() {
		return $this->firstname . " " . $this->lastname;
	}

	public function isAdmin() {
		return $this->belongsToGroup(1);
	}

	public function belongsToGroup($id) {
		return $this->groups()->where('groups.id', $id)->exists();
	}

	public static function administrators() {
		return User::all()->reject(function($u) {
			return !$u->isAdmin();
		});
	 }
}
