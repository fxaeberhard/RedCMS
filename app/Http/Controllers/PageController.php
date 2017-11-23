<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageBlock;
use App\Text;
use Illuminate\Http\Request;

class PageController extends Controller {

	// function index() {
	//  $page = Page::find(1);

	//  return view('home', [
	//      'page' => $page
	//  ]);
	// }

	public function index(Request $request) {
		return view("admin.pages", ["pages" => Page::orderBy('locked', 'DESC')->orderBy('name_' . config('app.locale'))->get()]);
	}

	public function store(Request $request) {
		$page = Page::create($request->all());
		$text = Text::create();
		PageBlock::createBlock($text, ['page_id' => $page->id]);
		// $block = Block::create(['model' => 'Text', 'model_id' => $text->id, 'view' => 'blocks.text', 'page_id' => $page->id]);
	}

	public function update(Request $request, Page $page) {
		$page->fill($request->all())->save();
	}

	public function destroy(Request $request, $page) {
		$page->delete();
	}
}
