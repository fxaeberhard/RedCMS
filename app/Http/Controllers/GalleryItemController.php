<?php

namespace App\Http\Controllers;

use App\GalleryItem;
use Illuminate\Http\Request;

class GalleryItemController extends Controller {

	public function store(Request $request) {

		$data = $request->all();

		$data['position'] = GalleryItem::max('position') + 1;

		$project = GalleryItem::create($data);
	}

	public function sort(Request $request) {
		foreach ($request->input('positions') as $index => $value) {
			$p = GalleryItem::find($value);
			$p->position = $index;
			$p->save();
		}
	}

	public function update(Request $request, GalleryItem $item) {
		$item->fill($request->all())->save();
	}

	public function destroy(Request $request, $item) {
		$item->delete();
	}
}
