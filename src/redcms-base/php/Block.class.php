<?php
/* 
RedCMS - 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/
class Tuple {
	var $_dbFields;
	var $_dbFieldsMap = array();
	var $_dbTable;
	var $fields;
	
	function Tuple($fields=array()) {
		if (!isset($fields['id'])) $fields['id'] = '';
		$this->fields = $fields;
	}
	// *** Fields managment methods *** //
	function get($f) {
		if (isset($this->fields[$f])) return $this->fields[$f];
		return null;
	}
	function __get($f) {
		if (isset($this->fields[$f])) return $this->fields[$f];
		else if (isset($this->_dbFieldsMap[$f]) && isset($this->fields[$this->_dbFieldsMap[$f]]))	
				return $this->fields[$this->_dbFieldsMap[$f]];
		else return null;
	}
	// *** DB interaction methods *** //
	function save(){
		$redCMS = RedCMS::getInstance();
		$values = array();
		$cols = array();
		foreach ($this->_dbFields as $f){
			if (isset($this->fields[$f])) {
				
				$insertCols1[] = '`'.$f.'`';
				$insertCols2[] = '?';
				$updateCols[] = '`'.$f.'`=?';
				
				//$values[] = $this->fields[$f];
				$values[] = ($this->fields[$f] !== '')?$this->fields[$f]:null;
			}
		}
		if (is_numeric($this->fields['id'])){
			$query = 'UPDATE '.$this->_dbTable.' SET '.implode(',', $updateCols).' WHERE id = '.$this->id;
			$statement = $redCMS->dbManager->prepare($query);
			return $statement->execute($values);
		} else {
			$statement = $redCMS->dbManager->prepare('INSERT INTO '.$this->_dbTable.' ('.implode(',', $insertCols1).') VALUES ('.implode(',', $insertCols2).')');
			$r = $statement->execute($values);
			if ($r) {
				$this->fields['id'] = $redCMS->dbManager->lastInsertId();
			}
			return $r;
		}
	}
	function delete() {
		$redCMS = RedCMS::getInstance();
		$query = 'DELETE FROM '.$this->_dbTable.' WHERE id=? LIMIT 1';
		$statement = $redCMS->dbManager->prepare($query);
		return $statement->execute(array($this->id));
	}
	function toJSON() {
		$ret = array();
		foreach ($this->_dbFieldsMap as $f => $t) {
			$ret[$f] = $this->fields[$t]; 
		}
		return $ret;
	}
}
class Block extends Tuple {
	var $_dbFields = array('parentId', 'type', 'text1', 'text2', 'text3', 'text4', 'text5', 'longtext1', 'template', 'link', 'read', 'write' );
	var $_dbTable = 'redcms_block';
	
	// *** Hierarchy and linked blocks managment methods *** //
	function getChildBlocks(){
		$redCMS = RedCMS::getInstance();
		$ret = BlockManager::getBlocksBySelect('parentId='.$this->id);
		return $ret;
	}
	function getLinkedBlocks($relationType){
		$redCMS = RedCMS::getInstance();
		return BlockManager::getLinkedBlocks( $this->id, $relationType );
	}
	var $_linkedBlocks = array();
	function &getLinkedBlock($relationType){
		if (!isset($this->_linkedBlocks[$relationType])) {
			$blocks = $this->getLinkedBlocks( $relationType );
			if (!empty($blocks)) $this->_linkedBlocks[$relationType] = $blocks[0];
			else $this->_linkedBlocks[$relationType] = null;
		}
		return $this->_linkedBlocks[$relationType];
	}
	function getTemplate() {
		$redCMS = RedCMS::getInstance();
		$tpl = TemplateManager::getTemplate();
		$tpl->assign("this", $this);
		return $tpl;
	}

	// *** Display managment methods *** //
	function getLabel(){
		return "No label provided";
	}
	function getLink(){
		if ($this->link) return ParamManager::getLink($this->link);
		else return ParamManager::getLink($this->id);
	}
	function getAdminJSON(){
		$redCMS = RedCMS::get();
		$admin = $this->getLinkedBlock('admin');
		if (isset($admin)) $admin = $admin->toJSON();
		else $admin = array();
		return $admin;
	}
	function renderAdminJSON() {
		return htmlspecialchars(json_encode($this->getAdminJSON()));
	}
	function getParamsJSON(){
		global $_REQUEST;
		return $_REQUEST;
	}
	function render() {
		$template = $this->getTemplate();
		$template->display($this->template);
	}
	
	// *** Rights Managment *** //
	var $_rights;
	function getRights(){
		if (!isset($this->_rights)){
			$redCMS = RedCMS::get();
			if ($redCMS->sessionManager->currentUser->belongsToAnyGroup()) {
				$stat = $redCMS->dbManager->prepare('SELECT max(`read`) as `read`, max(`write`) as `write` from redcms_groupxblock'.
					' WHERE idBlock=? AND idGroup in '.$redCMS->sessionManager->currentUser->getGroupsQuery());
				if ($stat->execute(array($this->id))) {
					$this->_rights = $stat->fetch(PDO::FETCH_ASSOC);
				} else $this->_rights = array('read'=>'0', 'write'=>'0');
			} else $this->_rights = array('read'=>'0', 'write'=>'0');
		}
		return $this->_rights;
	}
	
	function canRead(){
		if ($this->read == '1') return true;
		else {
			$this->getRights();
			return $this->_rights['read'] == '1';
		}
	}
	function canWrite(){
		if ($this->write == '1') return true;
		else {
			$this->getRights();
			return $this->_rights['write'] == '1';
		}
	}
}

class WrapperBlock extends Block {
	var $_wrappedBlock;
	function getWrappedBlock(){
		if (!isset($this->_wrappedBlock)){
			$targetBlock = $this->getLinkedBlock('target');
			$newFields = json_decode($this->longtext1, true);
			$newFields = array_merge($targetBlock->fields, $newFields);
			$blocks = BlockManager::getBlocksByFields(array($newFields));
			$this->_wrappedBlock = $blocks[0];
		}
		return $this->_wrappedBlock;
	}
	function render() {
		$this->getWrappedBlock()->render();
	}
}
class Group extends Tuple {
	var $_dbFields = array('name','title');
	var $_dbTable = 'redcms_group';
}
class GroupXBlock extends Tuple {
	var $_dbFields = array('idBlock','idGroup', 'read', 'write' );
	var $_dbTable = 'redcms_groupxblock';
}
class BlockXBlock extends Tuple {
	var $_dbFields = array('blockId','subBlockId', 'relationType');
	var $_dbTable = 'redcms_blockxblock';
}
class UserXGroup extends Tuple {
	var $_dbFields = array('idUser','idGroup');
	var $_dbTable = 'redcms_userxgroup';
}
class LoginManagerBlock extends Block {
	function render() {
		global $_REQUEST;
		$redCMS = RedCMS::getInstance();
		$ret = array();
		switch ($_REQUEST['action']) {
			case 'login':
				if ($redCMS->sessionManager->login($_REQUEST['username'], $_REQUEST['password'])) {
					$ret = array('result' => 'success', 'msg' => 'Vous êtes maintenant connecté');
				} else {
					$ret = array('result' => 'error', 'msg' => 'Mot de passe ou nom d\'utilisateur incorrect');
				}
				break;
			case 'logout':
				$redCMS->sessionManager->logout();
				$ret = array('result' => 'success', 'msg' => 'Vous avez été déconnecté');
				break;
			default:
				$ret = array('result' => 'error', 'msg' => 'Unknown or missing action parameter');
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
?>