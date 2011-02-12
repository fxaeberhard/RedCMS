<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/
class Action extends Block {
	function getLabel(){
		return $this->fields['text1'];
	}
}

class LoginAction extends Action {
	function getLabel(){
		global $redCMS;
		if ($redCMS->sessionManager->isLoggedIn()){
			return $this->fields['text2'];
		} else {
			return $this->fields['text1'];
		}
	}
}
class PageLinkAction extends Action {
}
class OpenPanelAction extends Action {
	
}
?>