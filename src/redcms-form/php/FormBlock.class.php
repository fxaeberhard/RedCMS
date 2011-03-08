<?php
/** 
* Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
* Code licensed under the BSD License:
* http://redcms.red-agent.com/license.html
*/

class FormBlock extends TreeStructure {
	
	function parseRequest(){
		global $_REQUEST;
		$redCMS = RedCMS::get();
		$fields = array();
		
		if (isset($_REQUEST['redaction'])){
			foreach ($this->getChildBlocks() as $b) {
				if (isset($_REQUEST[$b->name])){
					$newValue = $_REQUEST[$b->name];
					
					switch ($b->formtype) {
						case 'DateField':
							$t = strtotime($newValue);
							$fields[$b->name] = Utils::sql_date($t);;
							break;
						case 'PasswordField':
							if ($newValue != '') 
								$fields[$b->name] = $redCMS->sessionManager->generateHash($newValue);
							break;
						default: 
							$fields[$b->name] = $newValue;
					}
				}
			}
		}
		return $fields;
	}
	function getFormFields(){
		$fields = array();
		
		foreach ($this->getChildBlocks() as $b) {
			$f = $b->toJSON();
			
			switch ($b->formtype) {
				case 'PasswordField':										//Password fields values are never sent to the client
					$f['value'] = '';
					break;
			}
			
			$fields[] = $f;
		}
		
		$fields[] = array('name'=>'redaction', 'type'=>'HiddenField', 'value' => 'Submit');	// Double this field since the submit button won't be transmitted if using file upload
		$fields[] = array('name'=>'redaction', 'type'=>'SubmitButton', 'value' => 'Submit');
		return $fields;
	}
	
	function render() {	
		// We parse the provided fields and merge them with the target block
		$template = $this->getTemplate();
		$template->assign('fields', $this->parseRequest());
		$template->display($this->template);
	}
}

class FormField extends Block {
	var $_dbFieldsMap = array('redid'=>'id', 'name' => 'text1', 'label' => 'text2', 'required' => 'text3', 'formtype' => 'text4', 'defaultValue' => 'text5');	

	function toJSON() {
		
		$ret = parent::toJSON();
		if ($ret['label'] == '') $ret['label'] = $this->name;
		
		$ret['value'] = $this->defaultValue;
		unset($ret['defaultValue']);
		
		$ret['type'] = $this->formtype;
		unset($ret['formtype']);
		
		$ret['required'] = $this->required == '1';
		
		return $ret;
	}
}
class GroupSelectFormField extends FormField {
	
	function toJSON() {
		$ret = parent::toJSON();
		$ret['choices'] = array();
		foreach (UserManager::getGroups() as $g) {
			$ret['choices'][] = array('label' => $g->name, 'value'=> ''.$g->id);
		}
		return $ret;
	}
}
class BlockSelectFormField extends FormField {
	
	function toJSON() {
		$ret = parent::toJSON();
		$ret['choices'] = array();
		foreach (BlockManager::getBlocksBySelect('type=\'PageBlock\' ORDER BY link') as $b) {
		//	print_r($b);
			$ret['choices'][] = array('label' => $b->getLabel(), 'value'=> ''.$b->id);
		}
		return $ret;
	}
}

class EditDBFormBlock extends FormBlock {
	
	var $_targetBlock;
	
	function onBlockSaved() {
		
	}
	
	function parseRequest(){
		global $_REQUEST;
		$fields = parent::parseRequest();
		
		if (isset($_REQUEST['id'])) $fields['id'] = $_REQUEST['id'];
		
		return $fields;
	}
	function getFormFields(){
		
		$redCMS = RedCMS::get();
		$this->getTargetBlock();
	
		$fields = parent::getFormFields();
		
		foreach ($fields as &$f) {
			$value = $this->_targetBlock->get($f['name']);
			if ($value !== null) $f['value'] = $value;
			
			switch ($f['type']) {
				case 'PasswordField':										//Password fields values are never sent to the client
					$f['value'] = '';
					break;
				/*case 'EditorField':
					$f['type'] = 'TextareaField';
					if (!mb_detect_encoding($value, $redCMS->config['charset'], true)) {
						$value = iconv("ISO-8859-1", "UTF-8", $value);
					}
					$f['value'] = str_replace(
					array('Ã©', 'Ã¨', 'Ãª', 'Å?', 'Ã ', 'Ã?', 'Ã¹', 'Ã¢', 'â??', 'Ã®', 'Ã?', 'Â«', 'Â»', 'Ã¯', 'Ã»', 'ÃÂ´', 'Â§', 'Ã´'),
					array('é',  'è',  'ê',  'œ',  'à',  'À',  'ù',  'â',  '\'',  'î',  'Î',  '«',  '»',  'ï',  'û',  'ô',   'ç',  'ô'),
					$value);*/
			}
		}
		$fields[] = array('name'=>'id', 'type'=>'HiddenField', 'value' => ''.$this->_targetBlock->id);
		return $fields;
	}
	
	function getTargetBlock(){
		//echo 'EditDBFormBlock.getTargetBlock()';
		return null;
	}
	function render() {		
		$this->getTargetBlock();
		$fields = $this->parseRequest();									// We parse the provided fields and merge them with the target block
		
		if ($this->_targetBlock) {
			$this->_targetBlock->fields = array_merge($this->_targetBlock->fields, $fields);
		}
		
		if (isset($_REQUEST['redaction'])) {								//Form has been sent for submission
			$ret = $this->_targetBlock->save($fields);
			if ($ret === true) {
				$this->onBlockSaved();
				$ret = array('result' => 'success', 'msg'=>'Changes have been made.');
			} else {
				$red = RedCMS::get();
				$ret = array('result' => 'error', 'msg'=>'Form unsuccessfully saved.');
			}
			echo json_encode($ret);
		} else {															//No action, we display the block in the regular way
			$template = $this->getTemplate();
			$template->display($this->template);
		}
	}
}
	
class EditBlockFormBlock extends EditDBFormBlock {

	function onBlockSaved(){
		global $_REQUEST;
		$red = RedCMS::get();
		foreach ($_REQUEST as $p => $v) {
			if (strpos($p, 'redcms_link_') !== false) {
				$linkType = str_replace('redcms_link_', '', $p);
				if (isset($v)) {
					$linkStatement = $red->dbManager->query('SELECT *, redcms_block.id AS blockId'.
					' FROM '.$red->_dbBlock.
					' LEFT JOIN '.$red->_dbBlockXBlock.
					' ON blockId='.$red->_dbBlock.'.id AND relationType=\''.$linkType.'\'  WHERE redcms_block.id='.$this->_targetBlock->id);
					$linkTuple = $linkStatement->fetch(PDO::FETCH_ASSOC);
					$linkTuple['relationType'] = $linkType;
					$linkTuple['subBlockId'] = $v;
					$link = new BlockXBlock($linkTuple);
					$link->save();
				}
			}
		}
	}
	function getFormFields(){
	
		$fields = parent::getFormFields();
		
		if ($this->_targetBlock->parentId) {
			$fields[] = array('name'=>'parentId', 'type'=>'HiddenField', 'value' => ''.$this->_targetBlock->parentId);
		}
		
		foreach ($fields as &$f) {
			if (strpos($f['name'], 'redcms_link_') !== false) {
				$linkType = str_replace('redcms_link_', '', $f['name']);	
				$targetBlock = $this->_targetBlock->getLinkedBlock($linkType);
				if ($targetBlock) $f['value'] = ''.$targetBlock->id;
			}
		}
		
		return $fields;
	}
	function parseRequest(){
		global $_REQUEST;
		$fields = parent::parseRequest();
		
		if (isset($_REQUEST['parentId'])) $fields['parentId'] = $_REQUEST['parentId'];
		
		return $fields;
	}
	
	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)){							
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {				// If we are editing an existing block, we retrieve it
				$this->_targetBlock = BlockManager::getBlockById($_REQUEST['id']);
			} else {
				if (isset($_POST['type'])) {									// Otherwise we try to instantiate a block with class provided in arguments
					//eval('$this->_targetBlock = new '.$_POST['type'].'();');	// PHP< 5.3.0
					$this->_targetBlock = new $_POST['type']();					// PHP>=5.3.0
				} else {														// And if no information is available we use a generic block
					$this->_targetBlock = new Block();
				}
			}	
			
		}
		return $this->_targetBlock;
	}
}

class EditGroupMembershipFormBlock extends EditDBFormBlock {
	/**
	 * FIXME should return groups with a corresponding class
	 * 
	 * @param int $blockId
	 */
	function getGetGroupMemberShipByUser($userId) {
		$red = RedCMS::get();
		$stat = $red->dbManager->query('SELECT *, redcms_group.id AS idGroup'.
			' FROM '.$red->_dbGroup.
			' LEFT JOIN '.$red->_dbUserXGroup.
			' ON idGroup='.$red->_dbGroup.'.id AND idUser='.$userId);
		return $stat->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function parseRequest(){
		global $_REQUEST;
		$fields = parent::parseRequest();
		if (isset($_REQUEST['redaction'])) {								// Form has been sent for submission
			
			foreach ($this->getGetGroupMemberShipByUser($this->getTargetBlock()->id) as $g) {	// We loop through the rights to select the one corresponding to 
				$isAMember = (isset($_REQUEST['membership_'.$g['idGroup']]));
				if ($isAMember && $g['id'] == '') {
					$g['idUser'] = $this->_targetBlock->id;					// For new tuples, we set the target id	
					$gTuple = new UserXGroup($g);
					$gTuple->save();
				} else if (!$isAMember && $g['id'] != '') {
					$gTuple = new UserXGroup($g);
					$gTuple->delete();
				}
			}
		}
		return $fields;
	}
	
	function getFormFields(){
		die ("Function not yet implemented.");
	}
	
	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)){							
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
				$this->_targetBlock = UserManager::getUserById($_REQUEST['id']);
			} else {
				$this->_targetBlock = new User();
			}	
		}
		return $this->_targetBlock;
	}
}


class EditRightsFormBlock extends EditDBFormBlock {
	/**
	 * FIXME should return groups with a corresponding class
	 * 
	 * @param int $blockId
	 */
	function getRightsByGroup($blockId) {
		$redCMS = RedCMS::get();
		return 	$redCMS->dbManager->query('SELECT *, redcms_group.id AS idGroup '.
			' FROM '.$redCMS->_dbGroup.
			' LEFT JOIN '.$redCMS->_dbGroupXBlock.
			' ON idGroup='.$redCMS->_dbGroup.'.id AND idBlock='.$blockId)->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function parseRequest(){
		//echo 'EditRightsFormBlock.parseRequest()';
		global $_REQUEST;
		$fields = parent::parseRequest();
		
		if (isset($_REQUEST['redaction'])) {									// Form has been sent for submission
			$fields['read'] = (isset($_REQUEST['read']))?1:0;
			$fields['write'] = (isset($_REQUEST['write']))?1:0;		
			$fields['publicread'] = (isset($_REQUEST['publicread']))?1:0;
			$fields['publicwrite'] = (isset($_REQUEST['publicwrite']))?1:0;
			
			foreach ($this->getRightsByGroup($this->getTargetBlock()->id) as $g) {	// We loop through the rights to select the one corresponding to 
				$r = (isset($_REQUEST['read_'.$g['idGroup']]));
				$w = (isset($_REQUEST['write_'.$g['idGroup']]));
				if ($r || $w || $g['id'] != '') {
					$g['idBlock'] = $this->_targetBlock->id;					// For new tuples, we set the target id	
					$g['read'] = ($r)?'1':'0';
					$g['write'] = ($w)?'1':'0';
					$gTuple = new GroupXBlock($g);
					$gTuple->save();
				}
			}
		}
		return $fields;
	}
	/**
	 * TODO Not sure this is working... (not in use)
	 */
	function getFormFields(){
		$redCMS = RedCMS::get();
		$fields = array();
		
		$this->getTargetBlock();
		
		$fields[] = array('name'=>'id', 'type'=>'HiddenField', 'value' => ''.$this->_targetBlock->id);
		$fields[] = array('name'=>'publicread', 'type'=>'CheckboxField', 'label' => 'Public read', 'checked' => $this->_targetBlock->publicread === 1);
		$fields[] = array('name'=>'publicwrite', 'type'=>'CheckboxField', 'label' => 'Public write', 'checked' => $this->_targetBlock->publicwrite === 1);
		$fields[] = array('name'=>'read', 'type'=>'CheckboxField', 'label' => 'Registered user read', 'checked' => $this->_targetBlock->read === 1);
		$fields[] = array('name'=>'write', 'type'=>'CheckboxField', 'label' => 'Registered user write', 'checked' => $this->_targetBlock->write === 1);
		
		foreach ($this->getRightsByGroup($this->_targetBlock->id) as $g) {				//we loop through the rights to select the one corresponding to 
			if (!isset($g['read'])) { $g['read'] = 0;$g['write'] = 0; }
			$fields[] = array('name'=>$g['name'].'_read', 'type'=>'CheckboxField', 'label' => $g['name'].' read', 'checked' => $g['read'] === 1);
			$fields[] = array('name'=>$g['name'].'_write', 'type'=>'CheckboxField', 'label' => $g['name'].' write', 'checked' => $g['write'] === 1);
		}
		
		$fields[] = array('name'=>'redaction', 'type'=>'SubmitButton', 'value' => 'Submit');
		return $fields;
	}
	
	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)){							
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
				$this->_targetBlock = BlockManager::getBlockById($_REQUEST['id']);
			} else {
				$this->_targetBlock = new Block();
			}	
		}
		return $this->_targetBlock;
	}
}

class EditGroupFormBlock extends EditDBFormBlock {
	
	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)){
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '')
				$this->_targetBlock = UserManager::getGroupById($_REQUEST['id']);
			else $this->_targetBlock = new Group();
		}
		return $this->_targetBlocks;
	}
}
class EditUserFormBlock extends EditDBFormBlock {
	
	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)){
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '')
				$this->_targetBlock = UserManager::getUserById($_REQUEST['id']);
			else $this->_targetBlock = new User();
		}
		return $this->_targetblock;
	}
}
class EditCurrentUserFormBlock extends EditUserFormBlock {
	
	function getTargetBlock() {
		if (!isset($this->_targetBlock)){
			$redCMS = RedCMS::get();
			$this->_targetBlock = $redCMS->sessionManager->getCurrentUser();
		}
		return $this->_targetblock;
	}
}
?>