<?php
/* 
RedCMS - 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

class Block {
	var $id;
	var $fields;
	
	static $_dbFields = array('parentId','type', 'text1', 'text2', 'text3', 'text4', 'text5', 'template', 'link', 'read', 'write' );
	
	function Block($fields=array()) {
		if (!isset($fields['id'])) $fields['id'] = '';
		$this->id = $fields['id'];
		$this->fields = $fields;
	}
	
	// *** Hierarchy and linked blocks managment methods *** //
	function getChildBlocks(){
		global $redCMS;
		return BlockManager::getBlocksBySelect('parentId='.$this->id);
	}
	function getLinkedBlocks($relationType){
		global $redCMS;
		return BlockManager::getLinkedBlocks( $this->id, $relationType );
	}
	function &getLinkedBlock($relationType){
		$blocks = $this->getLinkedBlocks( $relationType );
		return $blocks[0];
	}
	function getTemplate() {
		global $redCMS;
		$tpl = TemplateManager::getTemplate();
		$tpl->assign("this", $this);
		return $tpl;
	}
	
	
	// *** Display managment methods *** //
	
	function getLink(){
		if ($this->fields['link'])return ParamManager::getLink($this->fields['link']);
		else return ParamManager::getLink($this->id);
	}
	function render() {
		$template = $this->getTemplate();
		$template->display($this->fields['template']);
	}
	

	// *** Fields managment methods *** //
	function get($f) {
		if (isset($this->fields[$f])) return $this->fields[$f];
		return null;
	}
	
	// *** DB interaction methods *** //
	
	function save(){
		global $redCMS;
		
		$values = array();
		$cols = array();
		foreach (Block::$_dbFields as $f){
			if (isset($this->fields[$f])) {
				
				$insertCols1[] = '`'.$f.'`';
				$insertCols2[] = '?';
				$updateCols[] = '`'.$f.'`=?';
				$values[] = $this->fields[$f];
			}
		}
		if (is_numeric($this->fields['id'])){
			$query = 'UPDATE '.$redCMS->_dbBlock.' SET '.implode(',', $updateCols).' WHERE id = '.$this->id;
		} else {
			$query = 'INSERT INTO '.$redCMS->_dbBlock.' ('.implode(',', $insertCols1).') VALUES ('.implode(',', $insertCols2).')';
		}
		$statement = $redCMS->dbManager->prepare($query);
		return $statement->execute($values);
	}
	function delete(){
		global $redCMS;
		$query = 'DELETE FROM '.$redCMS->_dbBlock.' WHERE id=? LIMIT 1';
		$statement = $redCMS->dbManager->prepare($query);
		return $statement->execute(array($this->fields['id']));
	}
}

class LoginManagerBlock extends Block {
	function render() {
		global $_REQUEST, $redCMS;
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
				$ret = array('result' => 'error', 'msg' => 'Unknows or missing action parameter');
				break;
		}
		echo json_encode($ret);
	}
}
?>