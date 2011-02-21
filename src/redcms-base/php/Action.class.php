<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/
class Action extends Block {
	function getLabel(){
		//if (isset($this->fields['text1']) && $this->fields['text1'] != ''){
			return $this->fields['text1'];
		//} else return 'No label available';
	}
	function getLink(){
		return '#';
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
class OpenPanelAction extends Action {
	function getLink(){
		$target = $this->getLinkedBlock("target");
		if ($target) return $target->getLink();
		else return parent::getLink();
	}
}
class PageLinkAction extends OpenPanelAction {
	
}
class DeleteAction extends Action {
	function render() {
		global $_REQUEST;
		if (isset($_REQUEST['id'])) {
			$b = BlockManager::getBlockById($_REQUEST['id']);
			if ($b->delete()) {
				$ret = array('result' => 'success', 'msg'=>'Block has been deleted');
			} else {
				$ret = array('result' => 'error', 'msg'=>'Error deleting block');
			}
			echo json_encode($ret);
		}
	}
}
?>