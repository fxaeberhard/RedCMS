<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use Debugbar;

class PageBlock extends Model {

	protected $guarded = [];

	public static function boot() {
		parent::boot();

		PageBlock::deleting(function ($pageBlock) {
			$pageBlock->block->delete();
		});
	}

	public function page() {
		return $this->belongsTo('App\Page');
	}
	
	public function block() {
		return $this->morphTo();
	}

	public function shortType() {
		return str_replace("App\\", '', $this->block_type);
	}

	public static function createBlock($target, $data = []) {

		$data = array_merge([
			'block_type' => $target->getClassName(), 'block_id' => $target->id,
			'view' => 'blocks.' . strtolower($target->getShortClassName()),
			'admin_view' => 'admin.' . strtolower($target->getShortClassName()),
			'position' => PageBlock::max('position') + 1],
			array_filter($data));

		return PageBlock::create($data);
	}
}
