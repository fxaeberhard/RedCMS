<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model {

	protected $guarded = ['pageBlock', '_token'];

	protected static function boot() {
		parent::boot();

		self::deleting(function ($block) {
			$block->pageBlock()->delete();
		});
	}

	public function pageBlock() {
		return $this->morphOne('App\PageBlock', 'block');
	}

	public function page() {
		return $this->pageBlock->page; 
	}

	public function getShortClassName() {
		return (new \ReflectionClass($this))->getShortName();
	}

	public function getClassName() {
		return get_class($this);
	}

	public function getTranslation($name) {
		return $this[$name . '_' . \App::getLocale()] ?? $this[$name . '_en'] ?? $this[$name . '_fr'];
	}
	// public function shortType() {
	// 	return "ii";
	// }
}
