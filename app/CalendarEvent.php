<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model {

	protected $guarded = ['_token'];

	public function calendar() {
		return $this->belongsTo('App\Calendar');
	}

}
