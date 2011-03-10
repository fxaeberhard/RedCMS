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
	function set($f, $v){
		$this->fields[$f] = $v;
	}
	
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
			$r = $statement->execute($values);
			if ($r) {
				return true;
			}else return $statement;
		} else {
			$statement = $redCMS->dbManager->prepare('INSERT INTO '.$this->_dbTable.' ('.implode(',', $insertCols1).') VALUES ('.implode(',', $insertCols2).')');
			$r = $statement->execute($values);
			if ($r) {
				$this->fields['id'] = $redCMS->dbManager->lastInsertId();
				return true;
			}else return $statement;
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
	var $_dbFields = array('parentId', 'type',  'text1', 'text2', 'text3', 'text4', 'text5', 'number1', 'date1', 'date2', 'longtext1', 
			'template', 'link', 'read', 'write', 'dateadded', 'dateupdated', 'owner', 'publicread', 'publicwrite');
	var $_dbTable = 'redcms_block';
	
	var $_parent;
	var $_linkedBlocks = array();
	var $_childBlocks;
	
	// *** Hierarchy and linked blocks managment methods *** //
	function getChildBlocks($orderBy = null){
		if (!isset($this->_childBlocks)) {
			$orderBy = ($orderBy)?' ORDER BY '.$orderBy:'';
			$this->_childBlocks = BlockManager::getBlocksBySelect('parentId='.$this->id.$orderBy);
			foreach ($this->_childBlocks as &$b) {
				$b->_parent = $this;
			}
		}
		return $this->_childBlocks;
	}
	function getLinkedBlocks($relationType){
		return BlockManager::getLinkedBlocks( $this->id, $relationType );
	}
	function &getLinkedBlock($relationType){
		if (!isset($this->_linkedBlocks[$relationType])) {
			$blocks = $this->getLinkedBlocks( $relationType );
			if (!empty($blocks)) $this->_linkedBlocks[$relationType] = $blocks[0];
			else $this->_linkedBlocks[$relationType] = null;
		}
		return $this->_linkedBlocks[$relationType];
	}
	function getLinkerBlocks($relationType){
		return BlockManager::getLinkerBlocks( $this->id, $relationType );
	}
	function parentBlock() {
		if (!isset($this->_parent)) {
			$this->_parent = BlockManager::getBlockById($this->parentId);
		}
		return $this->_parent;
	}
	function ancestor($class){
		$a = $this->parentBlock();
		while (!($a instanceof $class)) {
			$a = $a->parentBlock();
			if (!$a) return null;
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
	function getLabel(){
		return "No label provided";
	}
	function getLink(){
		if ($this->link) return ParamManager::getLink($this->link);
		else return ParamManager::getLink($this->id);
	}
	
	function render() {
		$template = $this->getTemplate();
		$template->display($this->template);
	}
	
	// *** Rights Managment *** //
	function getOwner(){
		return UserManager::getUserById($this->owner);
	}
	
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
		$redCMS = RedCMS::get();
		if ($this->publicread == '1') return true;
		else if ($this->read == '1' && $redCMS->sessionManager->isLoggedIn()) return true;
		else {
			$this->getRights();
			return $this->_rights['read'] == '1';
		}
	}
	function canWrite(){
		if ($this->publicwrite == '1') return true;
		else if ($this->write == '1' && $redCMS->sessionManager->isLoggedIn()) return true;
		else {
			$this->getRights();
			return $this->_rights['write'] == '1';
		}
	}
	function save() {
		$redCMS = RedCMS::getInstance();
		//Could be useful
		//if (!$this->type) $this->set('type', get_class($this));
		if (!is_numeric($this->fields['id'])){
			$this->set('owner', $redCMS->sessionManager->getCurrentUser()->id);
			$this->set('dateadded', Utils::sql_date());	
		}
		$this->set('dateupdated', Utils::sql_date());	
		return parent::save();
	}
	
	// *** Admin Menu Managment *** //
	function getAdminJSON(){
		$admin = $this->getLinkedBlock('admin');
		if (isset($admin)) $admin = $admin->toJSON();
		else $admin = array();
		return $admin;
	}
	function renderAdminJSON() {
		return htmlspecialchars(json_encode($this->getAdminJSON()));
	}
	
	// *** Parameters Stack Managment *** //
	
	var $paramsStack = array();
	function nextParam() {
		$redCMS = RedCMS::get();
		if ($redCMS->paramManager->hasMore()) {
			$param = $redCMS->paramManager->next();
			$this->paramsStack['p1'] = $param;
			return $param;
		} else return null;
	}
	function getParamsJSON(){
		global $_REQUEST;
		$redCMS = RedCMS::get();
		return array_merge($_REQUEST, $this->paramsStack, $redCMS->paramManager->currentStackJSON());
	}
	function renderParamsJSON(){
		return htmlspecialchars(json_encode($this->getParamsJSON()));
	}
	
	function renderBlockAttributes() {
		echo 'redid="', $this->id,'" redparams="', $this->renderParamsJSON(),'" redadmin="', $this->renderAdminJSON(),'"';
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