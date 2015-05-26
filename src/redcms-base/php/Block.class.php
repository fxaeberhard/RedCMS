<?php

/*
  RedCMS -
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

class Tuple {

	var $_dbFields;
	var $_dbFieldsMap = [];
	var $_dbTable;
	var $fields;

	function Tuple($fields = []) {
		if (!isset($fields['id'])) {
			$fields['id'] = '';
		}
		$this->fields = $fields;
	}

	// *** Fields managment methods *** //
	function set($f, $v) {
		$this->fields[$f] = $v;
	}

	function get($f) {
		if (isset($this->fields[$f])) {
			return $this->fields[$f];
		}
		return null;
	}

	function __get($f) {
		if (isset($this->fields[$f])) {
			return $this->fields[$f];
		} else if (isset($this->_dbFieldsMap[$f]) && isset($this->fields[$this->_dbFieldsMap[$f]])) {
			return $this->fields[$this->_dbFieldsMap[$f]];
		} else {
			return null;
		}
	}

	// *** DB interaction methods *** //
	function save() {
		$redCMS = RedCMS::get();
		$values = [];
		foreach ($this->_dbFields as $f) {
			if (isset($this->fields[$f])) {

				$insertCols1[] = '`' . $f . '`';
				$insertCols2[] = '?';
				$updateCols[] = '`' . $f . '`=?';

				//$values[] = $this->fields[$f];
				$values[] = ($this->fields[$f] !== '') ? $this->fields[$f] : null;
			}
		}
		if (is_numeric($this->fields['id'])) {
			$statement = $redCMS->dbManager->prepare('UPDATE ' . $this->_dbTable . ' SET ' . implode(',', $updateCols) . ' WHERE id = ' . $this->id);
			$r = $statement->execute($values);
			if ($r) {
				return true;
			} else {
				return $statement;
			}
		} else {
			$statement = $redCMS->dbManager->prepare('INSERT INTO ' . $this->_dbTable . ' (' . implode(',', $insertCols1) . ') VALUES (' . implode(',', $insertCols2) . ')');
			$r = $statement->execute($values);
			if ($r) {
				$this->fields['id'] = $redCMS->dbManager->lastInsertId();
				return true;
			} else {
				return $statement;
			}
		}
	}

	function delete() {
		$query = 'DELETE FROM ' . $this->_dbTable . ' WHERE id=? LIMIT 1';
		$statement = RedCMS::get()->dbManager->prepare($query);
		return $statement->execute([$this->id]);
	}

	function toJSON() {
		$ret = [];
		foreach ($this->_dbFieldsMap as $f => $t) {
			$ret[$f] = $this->fields[$t];
		}
		return $ret;
	}

}

class Block extends Tuple {

	var $_dbFields = ['parentId', 'type', 'text1', 'text2', 'text3', 'text4', 'text5', 'number1', 'date1', 'date2', 'longtext1',
		'template', 'link', 'read', 'write', 'dateadded', 'dateupdated', 'owner', 'publicread', 'publicwrite'];
	var $_dbTable = 'redcms_block';
	var $_parent;
	var $_linkedBlocks = [];
	var $_childBlocks;

	// *** Hierarchy and linked blocks managment methods *** //
	function getChildBlocks($orderBy = null) {
		if (!isset($this->_childBlocks)) {
			$orderBy = $orderBy ? ' ORDER BY ' . $orderBy : '';
			$this->_childBlocks = $this->getChildBlocksS('parentId=' . $this->id . $orderBy);
		}
		return $this->_childBlocks;
	}

	function getChildBlocksS($select) {
		$blocks = BlockManager::getBlocksBySelect('parentId=' . $this->id . ($select ? " AND " . $select : ""));
		foreach ($blocks as &$b) {
			$b->_parent = $this;
		}
		return $blocks;
	}

	function getLinkedBlocks($relationType) {
		return BlockManager::getLinkedBlocks($this->id, $relationType);
	}

	function &getLinkedBlock($relationType) {
		if (!isset($this->_linkedBlocks[$relationType])) {
			$blocks = $this->getLinkedBlocks($relationType);
			if (!empty($blocks)) {
				$this->_linkedBlocks[$relationType] = $blocks[0];
			} else {
				$this->_linkedBlocks[$relationType] = null;
			}
		}
		return $this->_linkedBlocks[$relationType];
	}

	function getLinkerBlocks($relationType) {
		return BlockManager::getLinkerBlocks($this->id, $relationType);
	}

	function parentBlock() {
		if (!isset($this->_parent)) {
			$this->_parent = BlockManager::getBlockById($this->parentId);
		}
		return $this->_parent;
	}

	function ancestor($class) {
		$a = $this->parentBlock();
		while (!($a instanceof $class)) {
			$a = $a->parentBlock();
			if (!$a) {
				return null;
			}
		}
		return $a;
	}

	// *** Template managment methods *** //
	function getTemplate() {
		$tpl = TemplateManager::getTemplate();
		$tpl->assign("this", $this);
		return $tpl;
	}

	// *** Display managment methods *** //
	function getLabel() {
		return "No label provided";
	}

	function getLink() {
		if ($this->link) {
			return ParamManager::getLink($this->link);
		} else {
			return ParamManager::getLink($this->id);
		}
	}

	function getPageLink() {
		$p = $this->ancestor("PageBlock");
		if ($p) {
			return $p->getLink();
		} else {
			return "#";
		}
	}

	function render() {
		$template = $this->getTemplate();
		$template->display($this->template);
	}

	function renderHeaders() {
		
	}

	// *** Rights Managment *** //
	function getOwner() {
		return UserManager::getUserById($this->owner);
	}

	var $_rights;

	function getRights() {
		if (!isset($this->_rights)) {
			$redCMS = RedCMS::get();
			if ($redCMS->sessionManager->currentUser->belongsToAnyGroup()) {
				$stat = $redCMS->dbManager->prepare('SELECT max(`read`) as `read`, max(`write`) as `write` from redcms_groupxblock' .
						' WHERE idBlock=? AND idGroup in ' . $redCMS->sessionManager->currentUser->getGroupsQuery());
				if ($stat->execute([$this->id])) {
					$this->_rights = $stat->fetch(PDO::FETCH_ASSOC);
				} else {
					$this->_rights = ['read' => '0', 'write' => '0'];
				}
			} else {
				$this->_rights = ['read' => '0', 'write' => '0'];
			}
		}
		return $this->_rights;
	}

	function canRead() {
		if ($this->publicread == '1') {
			return true;
		} else if ($this->read == '1' && RedCMS::get()->sessionManager->isLoggedIn()) {
			return true;
		} else {
			$this->getRights();
			return $this->_rights['read'] == '1';
		}
	}

	function canWrite() {
		// FIXME shortcut for development only, to remove
		$redCMS = RedCMS::get();
		if ($redCMS->sessionManager->currentUser->isAMember('1') || $redCMS->sessionManager->currentUser->isAMember('2')) {
			return true;
		}

		if ($this->publicwrite == '1') {
			return true;
		} else if ($this->write == '1' && $redCMS->sessionManager->isLoggedIn()) {
			return true;
		} else {
			$this->getRights();
			return $this->_rights['write'] == '1';
		}
	}

	function save() {
		//Could be useful
		//if (!$this->type) $this->set('type', get_class($this));
		if (!is_numeric($this->fields['id'])) {
			$this->set('owner', RedCMS::get()->sessionManager->getCurrentUser()->id);
			$this->set('dateadded', Utils::sql_date());
		}
		$this->set('dateupdated', Utils::sql_date());
		return parent::save();
	}

	// *** Admin Menu Managment *** //
	function getAdminJSON() {
		$admin = $this->getLinkedBlock('admin');
		if (isset($admin)) {
			$admin = $admin->toJSON();
		} else {
			$admin = [];
		}
		return $admin;
	}

	function renderAdminJSON() {
		if ($this->canWrite()) {
			return htmlspecialchars(json_encode($this->getAdminJSON()));
		} else {
			return '{}';
		}
	}

	// *** Parameters Stack Managment *** //

	var $paramsStack = [];

	function nextParam() {
		$redCMS = RedCMS::get();
		if ($redCMS->paramManager->hasMore()) {
			$param = $redCMS->paramManager->next();
			$this->paramsStack['p1'] = $param;
			return $param;
		} else {
			return null;
		}
	}

	function getParamsJSON() {
		global $_REQUEST;
		return array_merge($_REQUEST, $this->paramsStack, RedCMS::get()->paramManager->currentStackJSON());
	}

	function renderParamsJSON() {
		return htmlspecialchars(json_encode($this->getParamsJSON()));
	}

	function renderBlockAttributes() {
		echo 'redid="', $this->id, '" redparams="', $this->renderParamsJSON(), '" redadmin="', $this->renderAdminJSON(), '"';
	}

}

class WrapperBlock extends Block {

	var $_wrappedBlock;

	function getWrappedBlock() {
		if (!isset($this->_wrappedBlock)) {
			$targetBlock = $this->getLinkedBlock('target');
			$newFields = json_decode($this->longtext1, true);
			$newFields = array_merge($targetBlock->fields, $newFields);
			$this->_wrappedBlock = BlockManager::getBlockByField($newFields);
			//$this->_wrappedBlock->fields['id'] = $this->id;
		}
		return $this->_wrappedBlock;
	}

	function render() {
		$this->getWrappedBlock()->render();
	}

}

class Group extends Tuple {

	var $_dbFields = ['name', 'title'];
	var $_dbTable = 'redcms_group';

}

class GroupXBlock extends Tuple {

	var $_dbFields = ['idBlock', 'idGroup', 'read', 'write'];
	var $_dbTable = 'redcms_groupxblock';

}

class BlockXBlock extends Tuple {

	var $_dbFields = ['blockId', 'subBlockId', 'relationType'];
	var $_dbTable = 'redcms_blockxblock';

}

class UserXGroup extends Tuple {

	var $_dbFields = ['idUser', 'idGroup'];
	var $_dbTable = 'redcms_userxgroup';

}

class LoginManagerBlock extends Block {

	function render() {
		global $_REQUEST;
		$redCMS = RedCMS::get();
		$ret = [];
		switch ($_REQUEST['action']) {
			case 'login':
				if ($redCMS->sessionManager->login($_REQUEST['username'], $_REQUEST['password'])) {
					$ret = ['result' => 'success', 'msg' => 'Vous êtes maintenant connecté'];
				} else {
					$ret = ['result' => 'error', 'msg' => 'Mot de passe ou nom d\'utilisateur incorrect'];
				}
				break;
			case 'logout':
				$redCMS->sessionManager->logout();
				$ret = ['result' => 'success', 'msg' => 'Vous avez été déconnecté'];
				break;
			default:
				$ret = ['result' => 'error', 'msg' => 'Unknown or missing action parameter'];
				break;
		}
		echo json_encode($ret);
	}

}

class TextBlock extends Block {

	function render() {
		echo $this->longtext1;
	}

}
