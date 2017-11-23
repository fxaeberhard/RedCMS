<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class MenuItem extends Model {

	protected $guarded = ['_token'];

	protected static function boot() {
		parent::boot();

		MenuItem::deleting(function ($menuItem) {
			$menuItem->items()->delete();
		});
	}

	public function page() {
		// return Cache::remember('menuitem_' . $this->id . '_page', 10, function() {
		return $this->belongsTo('App\Page');
		// }
	}

	public function items() {
		return $this->hasMany('App\MenuItem')->orderBy('position')->with('page');
	}

	public function label() {
		switch ($this->type) {
			case 'link':
				if ($this->page) return $this->page->name();
			case 'login':
				if (Auth::guest()) {
					return  __('app.login');
				} else {
					return __('app.logout');
				}
		}
		return $this['label_' . \App::getLocale()] ?? $this['label_en'] ?? $this['label_fr'] ?? __('app.untitled');
	}

	public function href() {
			switch ($this->type) {
				case 'link':
					return page($this->page);
				case 'login':
					if (Auth::guest()) {
						return  url('/login');
					} else {
						return url('/logout');
					}
			}
	}
	public function active() {
		return urldecode(Request::url()) == $this->href();
	}
}
