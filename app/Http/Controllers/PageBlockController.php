<?php

namespace App\Http\Controllers;

use App\PageBlock;
use Illuminate\Http\Request;

class PageBlockController extends Controller {

	public function show(Request $request, PageBlock $pageBlock) {
		\App::setLocale(session('lang', 'en'));
		return view($pageBlock->view, ['pageBlock' => $pageBlock, 'block' => $pageBlock->block]);
	}

	public function update(Request $request, PageBlock $pageBlock) {
		$pageBlock->name = $request->input('name');
		$pageBlock->save();
	}
}
