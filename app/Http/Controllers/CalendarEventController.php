<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use Illuminate\Http\Request;

class CalendarEventController extends Controller {

	public function store(Request $request) {
		$data = $request->all();
		$item = CalendarEvent::create($data);
	}

	public function update(Request $request, $item) {
		$item->fill($request->all())->save();
	}

	public function destroy(Request $request, $item) {
		$item->delete();
	}
}
