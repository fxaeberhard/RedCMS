<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/
class Action extends Block {	
	
	var $_dbFieldsMap = array('label' => 'text1', 'action' => 'text2', 'filter' => 'text3');
	
	function getLabel(){
		return $this->label;
	}
	function getLink(){
		return '#';
	}

}

class LoginAction extends Action {
	
	var $_dbFieldsMap = array('loginLabel' => 'text1', 'logoutLabel' => 'text1');
	
	function getLabel(){
		$redCMS = RedCMS::getInstance();
		if ($redCMS->sessionManager->isLoggedIn()){
			return $this->loginLabel;
		} else {
			return $this->logoutLabel;
		}
	}
}
class TargetBlockAction extends Action {
	var $_target;
	function getTarget() {
		//return $this->getLinkedBlock('target');
		if (!isset($this->_target)) {
			$this->_target = $this->getLinkedBlock('target');
		}
		return $this->_target;
	}
	function getLink(){
		$target = $this->getTarget();
		if ($target) return $target->getLink();
		else return parent::getLink();
	}
}
class OpenPanelAction extends TargetBlockAction {
	
}
class AsyncRequestAction extends TargetBlockAction {
	
}
class PageLinkAction extends TargetBlockAction {
	function getLabel(){
		$target = $this->getTarget();
		if ($target) return $target->getLabel();
		else return parent::getLabel();
	}
}
class DeleteAction extends Action {
	function getTargetTuple(){
		return null;
	}
	function getLink() {
		return Block::getLink();
	}	
	function render() {
		global $_REQUEST;
		if (isset($_REQUEST['id'])) {
			$b = $this->getTargetTuple();
			if ($b->delete()) {
				$ret = array('result' => 'success', 'msg'=>'Block has been deleted');
			} else {
				$ret = array('result' => 'error', 'msg'=>'Error deleting block');
			}
			echo json_encode($ret);
		}
	}
}
class DeleteBlockAction extends DeleteAction {
	function getTargetTuple(){
		global $_REQUEST;
		return BlockManager::getBlockById($_REQUEST['id']);;
	}
}
class DeleteGroupAction extends DeleteAction {	
	function getTargetTuple(){
		global $_REQUEST;
		return UserManager::getGroupById($_REQUEST['id']);;
	}
}
class DeleteUserAction extends DeleteAction {
	function getTargetTuple(){
		global $_REQUEST;
		return UserManager::getUserById($_REQUEST['id']);;
	}
}
class NewWindowHrefAction extends Action {
	
}
class HrefAction extends Action {
	
}
?>