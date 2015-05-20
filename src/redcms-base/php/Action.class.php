<?php

/*
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

class Action extends Block {

	var $_dbFieldsMap = array('label' => 'text1', 'action' => 'text2', 'filter' => 'text3');

	function getLabel() {
		return $this->label;
	}

	function getLink() {
		return '#';
	}

	function save() {
		if (!is_numeric($this->id)) {
			$red = RedCMS::getInstance();
			$stat = $red->dbManager->prepare('SELECT MAX(number1) FROM redcms_block WHERE parentId=?');
			$stat->execute(array($this->parentId));
			$r = $stat->fetchAll(PDO::FETCH_NUM);
			$this->fields['number1'] = $r[0][0] + 1;
		}
		return parent::save();
	}

}

class LoginAction extends Action {

	var $_dbFieldsMap = array('loginLabel' => 'text1', 'logoutLabel' => 'text2');

	function getLabel() {
		$redCMS = RedCMS::getInstance();
		if ($redCMS->sessionManager->isLoggedIn()) {
			return $this->logoutLabel;
		} else {
			return $this->loginLabel;
		}
	}

}

class TargetBlockAction extends Action {

	function getTarget() {
		return $this->getLinkedBlock('target');
	}

	function getLink() {
		$target = $this->getTarget();
		if ($target)
			return $target->getLink();
		else
			return parent::getLink();
	}

	function canRead() {
		$target = $this->getTarget();
		if ($target)
			return $target->canRead();
		else
			return parent::canRead();
	}

	function canWrite() {
		$target = $this->getTarget();
		if ($target)
			return $target->canWrite();
		else
			return parent::canWrite();
	}

}

class OpenPanelAction extends TargetBlockAction {
	
}

class AsyncRequestAction extends TargetBlockAction {
	
}

class PageLinkAction extends TargetBlockAction {

	function getLabel() {

		if ($this->label)
			return $this->label;

		$target = $this->getTarget();
		if ($target)
			return $target->getLabel();

		return parent::getLabel();
	}

}

class DeleteAction extends Action {

	function getTargetTuple() {
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
				$ret = array('result' => 'success', 'msg' => 'Block has been deleted');
			} else {
				$ret = array('result' => 'error', 'msg' => 'Error deleting block');
			}
			echo json_encode($ret);
		}
	}

}

class DeleteBlockAction extends DeleteAction {

	function getTargetTuple() {
		global $_REQUEST;
		return BlockManager::getBlockById($_REQUEST['id']);
		;
	}

}

class DeleteGroupAction extends DeleteAction {

	function getTargetTuple() {
		global $_REQUEST;
		return UserManager::getGroupById($_REQUEST['id']);
		;
	}

}

class DeleteUserAction extends DeleteAction {

	function getTargetTuple() {
		global $_REQUEST;
		return UserManager::getUserById($_REQUEST['id']);
		;
	}

}

class NewWindowHrefAction extends Action {
	
}

class HrefAction extends Action {
	
}

?>