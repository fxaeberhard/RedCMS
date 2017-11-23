<?php

namespace App;

use App\Block;

class Blog extends Block {

	public function posts() {
		return $this->hasMany('App\BlogPost')->orderBy('created_at', 'DESC');
	}

}
