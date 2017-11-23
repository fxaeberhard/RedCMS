<?php

namespace App;

use App\Block;

class Gallery extends Block {

	protected $guarded = ['items', '_class', 'pageBlock'];

	protected static function boot() {
		parent::boot();

		Gallery::deleting(function ($gallery) {
			$gallery->items()->delete();
		});
	}

	public function items() {
		return $this->hasMany('App\GalleryItem')->orderBy('position');
	}

	public function itemsWithID3() {

		require_once __DIR__ . "/../vendor/getid3/getid3.php";

		$items = $this->items;
		$getID3 = new \getID3;

		foreach ($items as $i) {
			$path = __DIR__ . '/../public/' . $i->url;
			$i->title = filename($i->url);
			if (is_file($path)) {
				$info = $getID3->analyze($path);
				\getid3_lib::CopyTagsToComments($info);

				$i->title = implode('<br>', $info['comments_html']['artist'])
				. ' - ' . str_replace("sample", "excerpt", implode('<br>', $info['comments_html']['title']));
				$i->playtime = $info['playtime_string'];
				// $list = str_replace("&amp;", "and", $list);
			}
		}
		return $items;
	}
}
