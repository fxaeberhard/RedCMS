<?php

namespace App;

use App\Block;
use App\CalendarEvent;
use Illuminate\Support\Facades\DB;

class Calendar extends Block {

	public function events() {
		return $this->hasMany('App\CalendarEvent')->orderBy('date');
	}

	public function futurEvents() {
		return $this->events()->where('date', '>=', DB::raw('now()'));
	}

	public function pastEvents() {
		return $this->events()->where('date', '<', DB::raw('now()'));
	}

}
