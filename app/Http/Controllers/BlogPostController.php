<?php

namespace App\Http\Controllers;

use App\BlogPost;
use Illuminate\Http\Request;

class BlogPostController extends Controller {

	public function store(Request $request) {
		$data = $request->all();
		$data['user_id'] = $request->user()->id;
		$item = BlogPost::create($data);
	}

	public function update(Request $request, $item) {
		$item->fill($request->all())->save();
	}

	public function destroy(Request $request, $item) {
		$item->delete();
	}
}
