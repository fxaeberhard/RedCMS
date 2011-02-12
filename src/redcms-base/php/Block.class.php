<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

class Block {
	var $id;
	var $fields;
	
	function Block($fields) {
		$this->id = $fields['id'];
		$this->fields = $fields;
	}
	
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
	function render() {
		$template = $this->getTemplate();
		$template->display($this->fields['template']);
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