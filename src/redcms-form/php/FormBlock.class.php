<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

class FormBlock extends TreeStructure {
	var $targetBlock;
	
	function getFormFields(){
		$fields = array();
		
		$fields[] = array('name'=>'id', 'type'=>'HiddenField', 'value' => ''.$this->targetBlock->id);
		if (isset($this->targetBlock->fields['parentId'])){
			$fields[] = array('name'=>'parentId', 'type'=>'HiddenField', 'value' => ''.$this->targetBlock->get('parentId'));
		}
		
		foreach ($this->getChildBlocks() as $b) {
			$f = array('name' => $b->get('text1'),
				'required' => $b->get('text3') == '1',
				'type' => $b->get('text4'),
				'label' => $b->get('text2'));
			
			$value = $this->targetBlock->get($b->get('text1'));
			if ($value !== null) $f['value'] = $value;
			else $f['value'] = $b->fields['text5'];
			
			switch ($b->get('text4')) {
				case 'PasswordField':											//Password fields values are never sent to the client
					$f['value'] = '';
					break;
			}
			
			$fields[] = $f;
		}
		
		$fields[] = array('name'=>'redaction', 'type'=>'HiddenField', 'value' => 'Submit');			// Doule this field since the submit button won't be transmitted if using file upload
		$fields[] = array('name'=>'redaction', 'type'=>'SubmitButton', 'value' => 'Submit');
		return $fields;
	}
	
	function parseRequest(){
		global $_REQUEST, $redCMS;
		$fields = array();
		
		if (isset($_REQUEST['redaction'])){
			foreach ($this->getChildBlocks() as $b) {
				if (isset($_REQUEST[$b->get('text1')])){
					$fields[$b->get('text1')] = $_REQUEST[$b->get('text1')];
					
				
					switch ($b->get('text4')) {
						case 'PasswordField':
							if ($_REQUEST[$b->get('text1')] == '') {
								unset($fields[$b->get('text1')]);
							} else $fields[$b->get('text1')] = $redCMS->sessionManager->generateHash($fields[$b->get('text1')]);
							break;
					}
				}
			}
		}
		if (isset($_REQUEST['id'])) $fields['id'] = $_REQUEST['id'];
		
		return $fields;
	}
}
class EditDBFormBlock extends FormBlock {
	
	function parseRequest(){
		global $_REQUEST;
		$fields = parent::parseRequest();
		
		if (isset($_REQUEST['parentId'])) $fields['parentId'] = $_REQUEST['parentId'];
		
		return $fields;
	}
	
	function render() {
		global $_REQUEST;
																
		if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
			$this->targetBlock = BlockManager::getBlockById($_REQUEST['id']);
		} else {
			$this->targetBlock = new Block();
		}	
		
		$fields = $this->parseRequest();
		$this->targetBlock->fields = array_merge($this->targetBlock->fields, $fields);
		
		if (isset($_REQUEST['redaction'])) {								//Form has been sent for submission
			if ($this->targetBlock->save($fields)) {
				$ret = array('result' => 'success', 'msg'=>'Changes have been made.');
			} else {
				$ret = array('result' => 'error', 'msg'=>'Form unsuccessfully saved.');
			}
			echo json_encode($ret);
		} else {
			$template = $this->getTemplate();
			$template->display($this->fields['template']);
		}
	}
}
class EditRightsFormBlock extends EditDBFormBlock {
	function parseRequest(){
		global $_REQUEST;
		$fields = parent::parseRequest();
		
		if (isset($_REQUEST['redaction'])) {
			$fields['read'] = (isset($_REQUEST['read']))?1:0;
			$fields['write'] = (isset($_REQUEST['write']))?1:0;
		}
		return $fields;
	}
	
	function getFormFields(){
		global $redCMS;
		$fields = array();
		
		$fields[] = array('name'=>'id', 'type'=>'HiddenField', 'value' => ''.$this->targetBlock->id);
		
		$fields[] = array('name'=>'read', 'type'=>'CheckboxField', 'label' => 'Default: read', 'checked' => $this->targetBlock->fields['read'] === 1);
		$fields[] = array('name'=>'write', 'type'=>'CheckboxField', 'label' => 'Default: write', 'checked' => $this->targetBlock->fields['write'] === 1);
		
		$rights = $redCMS->dbManager->query('SELECT * FROM '.$redCMS->_dbGroup.
			' LEFT JOIN '.$redCMS->_dbGroupXBlock.' ON idGroup='.$redCMS->_dbGroup.'.id AND idBlock='.$this->targetBlock->id)->fetchAll(PDO::FETCH_ASSOC);
		//print_r($rights);
		//WHERE idBlock='.$this->targetBlock->id
		foreach ($rights as $g) {
			//print_r($g);
			//we loop through the rights to select the one corresponding to 
			if (!isset($g['read'])) $g['read'] = 0;
			$fields[] = array('name'=>'read_'.$g['name'], 'type'=>'CheckboxField', 'label' => $g['name'].' read', 'checked' => $g['read'] === 1);
			if (!isset($g['write'])) $g['write'] = 0;
			$fields[] = array('name'=>'write_'.$g['name'], 'type'=>'CheckboxField', 'label' => $g['name'].' write', 'checked' => $g['write'] === 1);
		}
		$fields[] = array('name'=>'redaction', 'type'=>'SubmitButton', 'value' => 'Submit');
		return $fields;
	}	
	function render() {
		global $_REQUEST;
																
		if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
			$this->targetBlock = BlockManager::getBlockById($_REQUEST['id']);
		} else {
			$this->targetBlock = new Block();
		}	
		
		$fields = $this->parseRequest();
		$this->targetBlock->fields = array_merge($this->targetBlock->fields, $fields);
		
		if (isset($_REQUEST['redaction'])) {								//Form has been sent for submission
			if ($this->targetBlock->save($fields)) {
				$ret = array('result' => 'success', 'msg'=>'Changes have been made.');
			} else {
				$ret = array('result' => 'error', 'msg'=>'Form unsuccessfully saved.');
			}
			echo json_encode($ret);
		} else {
			$template = $this->getTemplate();
			$template->display($this->fields['template']);
		}
	}
}

class EditUserFormBlock extends FormBlock {
	var $targetBlock;
	
	function render() {
		global $_REQUEST;
																
		if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
			$this->targetBlock = UserManager::getUserById($_REQUEST['id']);
		} else {
			$this->targetBlock = new User();
		}	
		
		$fields = $this->parseRequest();
		$this->targetBlock->fields = array_merge($this->targetBlock->fields, $fields);
		
		if (isset($_REQUEST['redaction'])) {								//Form has been sent for submission
			if ($this->targetBlock->save()) {
				$ret = array('result' => 'success', 'msg'=>'Changes have been made.');
			} else {
				$ret = array('result' => 'error', 'msg'=>'Form unsuccessfully saved.');
			}
			echo json_encode($ret);
		} else {
			$template = $this->getTemplate();
			$template->display($this->fields['template']);
		}
	}
}

class FormField extends Block {
	
}
?>