<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\PageBlock;
use Illuminate\Http\Request;

class GalleryController extends Controller {

	public function store(Request $request) {

		$data = $request->all();

		$gallery = Gallery::create($data);

		if ($request->exists('items')) {
			$gallery->items()->createMany($request->input('items'));
		}
		PageBlock::createBlock($gallery, $request->input('pageBlock')[0]);
	}

	public function update(Request $request, Gallery $gallery) {
		$gallery->fill($request->all())->save();

		// Remove pictures
		foreach ($gallery->items as $item) {
			$nitem = null;
			if ($request->exists('items')) {
				foreach ($request->input('items') as $v) {
					if (isset($v['id']) && $v['id'] == $item->id) {
						$nitem = $v;
						break;
					}
				}
			}
			if (!$nitem) {
				$item->delete();
			}
		}

		// Add and update pictures
		if ($request->exists('items')) {
			foreach ($request->input('items') as $index => $item) {
				$item['position'] = $index;
				$gallery->items()->updateOrCreate(['id' => isset($item['id']) ? $item['id'] : null], $item);
			}
		}
	}

	public function destroy(Request $request, Gallery $gallery) {
		$gallery->delete();
	}
}
