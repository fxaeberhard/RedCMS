<?php

namespace App;

use App\Block;

class Menu extends Block {

	protected $guarded = ['_class', 'pageBlock', 'items'];

	protected static function boot() {
		parent::boot();

		Menu::deleting(function ($menu) {
			// $page->blocks()->delete();// not triggering events
			$menu->items->each(function ($item) {
				$item->delete();
			});
		});
	}

	public function items() {
		return $this->hasMany('App\MenuItem')->orderBy('position')->with('page');
	}
}
