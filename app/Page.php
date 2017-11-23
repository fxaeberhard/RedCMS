<?php

namespace App;

use App\PageBlock;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	protected $guarded = ['_token'];

	protected static function boot() {
		parent::boot();

		Page::deleting(function ($page) {
			// $page->blocks()->delete();// not triggering events
			$page->pageBlocks->each(function ($pageBlock) {
				$pageBlock->delete();
			});
		});
	}

	public function pageBlocks() {
		return $this->hasMany('App\PageBlock')->with('block')->orderBy('position');
	}

	public static function staticBlocks() {
		return PageBlock::where('page_id', 0)->orderBy('position')->get();
	}

	public function name() {
		return $this['name_' . \App::getLocale()];
	}

	public function title() {
		return $this['title_' . \App::getLocale()];
	}

	public function description() {
		return $this['description_' . \App::getLocale()];
	}
}
