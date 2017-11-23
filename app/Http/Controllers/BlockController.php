<?php

namespace App\Http\Controllers;

use App\Block;
use App\PageBlock;
use Illuminate\Http\Request;

class BlockController extends Controller {

	public function edit(Request $request) {
		\App::setLocale(session('lang', \App::getLocale()));

		$class = "App\\" . $request->input('model');
		$model = $class::find($request->input('modelId'));

		$view = $model->pageBlock->admin_view ?? 'admin.' . strtolower($request->input('model'));

		return view($view, array('model' => $model));
	}

	public function add(Request $request) {
		\App::setLocale(session('lang', \App::getLocale()));

		$class = "App\\" . $request->input('model');
		$model = new $class();

		if ($request->has('data')) {
			$vals = json_decode($request->input('data'));
			if (isset($vals->pageBlock)) {
				$model->pageBlock = $vals->pageBlock;
			}
			$model->fill((array) $vals);
		}
		$view = $model->pageBlock->admin_view ?? 'admin.' . strtolower($request->input('model'));
		return view($view, array('model' => $model));
	}

	public function store(Request $request) {

		$data = $request->all();

		$class = $request->input('_class') ?? 'App\Text';
		$item = $class::create($data);

		PageBlock::createBlock($item, $request->input('pageBlock')[0]);
	}

	public function update(Request $request, Block $block) {
		$block->fill($request->all())->save();
		$block->pageBlock->fill($request->input('pageBlock')[0])->save();
	}

	public function destroy(Request $request, Block $block) {
		$block->delete();
	}
}
