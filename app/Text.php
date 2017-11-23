<?php

namespace App;

use App\Block;

class Text extends Block {

	public function content() {
		return $this->getTranslation('content');
	}
}
