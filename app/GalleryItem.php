<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model {

	protected $guarded = ['_token'];

	public function description() {
		return $this['description_' . \App::getLocale()] ?? $this['description_en'];
	}
}
