<?php

namespace App\Http\Controllers;

use App\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller {

	public function store(Request $request) {

		// $v = Validator::make(Input::all(), $rules);

		// if ($v->passes())
		// {
		$data = $request->all();

		$data['position'] = MenuItem::max('position') + 1;

		$item = MenuItem::create($data);

		// }
	}

	public function sort(Request $request) {
		foreach ($request->input('positions') as $index => $value) {
			$p = MenuItem::find($value);
			$p->position = $index;
			$p->save();
		}
	}

	public function update(Request $request, MenuItem $item) {
		$item->fill($request->all())->save();
	}

	public function destroy(Request $request, $item) {
		$item->delete();
	}
}
