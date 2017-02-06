<?php

/**
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 */
class FormBlock extends TreeStructure {

	function parseRequest() {
		global $_REQUEST;
		$fields = [];

		if (isset($_REQUEST['redaction'])) {
			foreach ($this->getChildBlocks() as $b) {
				if (isset($_REQUEST[$b->name])) {
					$newValue = $_REQUEST[$b->name];
					switch ($b->formtype) {
						case 'DateField':
						case 'datepicker':
						case 'date':
							if ($newValue != "") {
								$newValue = strstr($newValue, " (", true); // Remove trailing dates because it causes DateTime constuctor to bug
								$dt = new DateTime($newValue);
								$fields[$b->name] = Utils::sql_date($dt->getTimestamp());
							}
							break;

						case 'PasswordField':
						case "password":
							if ($newValue != '') {
								$fields[$b->name] = RedCMS::get()->sessionManager->generateHash($newValue);
							}
							break;

						case 'TextareaField':
						case "text":
							$newValue = nl2br($newValue);

						default:
							$fields[$b->name] = $newValue;
					}
				}
			}
		}
		return $fields;
	}

	function getFormFields() {
		$fields = [];

		foreach ($this->getChildBlocks("number1") as $b) {
			$f = $b->toJSON();

			switch ($b->formtype) {
				case 'PasswordField': //Password fields values are never sent to the client
				case "password":
					$f['value'] = '';
					break;
			}
			$fields[] = $f;
		}

		$fields[] = ['name' => 'redaction', 'type' => 'HiddenField', 'value' => 'Submit']; // Double this field since the submit button won't be transmitted if using file upload
//		$fields[] = array('name'=>'redaction', 'type'=>'SubmitButton', 'value' => 'Submit');
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

	var $_dbFieldsMap = ['name' => 'text1', 'label' => 'text2', 'required' => 'text3', 'formtype' => 'text4', 'defaultValue' => 'text5'];

	function toJSON() {

		$ret = parent::toJSON();

		if ($this->longtext1) {
			$params = json_decode($this->longtext1);
			foreach ($params as $k => $v) {
				$ret[$k] = $v;
			}
		}

		if ($ret['label'] == '') {
			$ret['label'] = $this->name;
		}

		$ret['redid'] = '' . $this->id;

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
		$ret['choices'] = [];
		foreach (UserManager::getGroups() as $g) {
			$ret['choices'][] = ['label' => $g->name, 'value' => '' . $g->id];
		}
		return $ret;
	}

}

class BlockSelectFormField extends FormField {

	function toJSON() {
		$ret = parent::toJSON();
		$ret['choices'] = [];
		$config = json_decode($this->longtext1, true);
		$filter = ($config['class']) ? $config['class'] : 'PageBlock';
		foreach (BlockManager::getBlocksBySelect('type=\'' . $filter . '\' ORDER BY link') as $b) {
			$ret['choices'][] = ['label' => $b->getLabel(), 'value' => '' . $b->id];
		}
		return $ret;
	}

}

class EditDBFormBlock extends FormBlock {

	var $_targetBlock;

	function onBlockSaved() {
		
	}

	function parseRequest() {
		global $_REQUEST;
		$fields = parent::parseRequest();

		if (isset($_REQUEST['id'])) {
			$fields['id'] = $_REQUEST['id'];
		}
		return $fields;
	}

	function getFormFields() {
		$targetBlock = $this->getTargetBlock();

		$fields = parent::getFormFields();

		foreach ($fields as &$f) {
			$value = $targetBlock->get($f['name']);
			if ($value !== null) {
				$f['value'] = $value;
			}

			switch ($f['type']) {
				case 'PasswordField': //Password fields values are never sent to the client
				case "password":
					$f['value'] = '';
					break;
				/* case 'EditorField':
				  $f['type'] = 'TextareaField';
				  if (!mb_detect_encoding($value, $redCMS->config['charset'], true)) {
				  $value = iconv("ISO-8859-1", "UTF-8", $value);
				  }
				  $f['value'] = str_replace(
				  array('Ã©', 'Ã¨', 'Ãª', 'Å?', 'Ã ', 'Ã?', 'Ã¹', 'Ã¢', 'â??', 'Ã®', 'Ã?', 'Â«', 'Â»', 'Ã¯', 'Ã»', 'ÃÂ´', 'Â§', 'Ã´'),
				  array('é',  'è',  'ê',  'œ',  'à',  'À',  'ù',  'â',  '\'',  'î',  'Î',  '«',  '»',  'ï',  'û',  'ô',   'ç',  'ô'),
				  $value); */
			}
		}
		$fields[] = ['name' => 'id', 'type' => 'HiddenField', 'value' => '' . $targetBlock->id];
		return $fields;
	}

	function getTargetBlock() {
		//echo 'EditDBFormBlock.getTargetBlock()';
		return null;
	}

	function render() {
		$targetBlock = $this->getTargetBlock();
		$fields = $this->parseRequest();   // We parse the provided fields and merge them with the target block

		if ($targetBlock) {
			$targetBlock->fields = array_merge($targetBlock->fields, $fields);
		}

		if (isset($_REQUEST['redaction'])) {  //Form has been sent for submission
			$ret = $targetBlock->save($fields);
			if ($ret === true) {
				$this->onBlockSaved();
				$ret = ['result' => 'success', 'msg' => 'Changes have been made.'];
			} else {
				$ret = ['result' => 'error', 'msg' => 'Form unsuccessfully saved.'];
			}
			echo json_encode($ret);
		} else {   //No action, we display the block in the regular way
			$template = $this->getTemplate();
			$template->display($this->template);
		}
	}

}

class EditBlockFormBlock extends EditDBFormBlock {

	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)) {
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') { // If we are editing an existing block, we retrieve it
				$this->_targetBlock = BlockManager::getBlockById($_REQUEST['id']);
			} else {
				if (isset($_POST['type'])) {   // Otherwise we try to instantiate a block with class provided in arguments
					//eval('$this->_targetBlock = new '.$_POST['type'].'();');	// PHP< 5.3.0
					$this->_targetBlock = new $_POST['type']();  // PHP>=5.3.0
				} else {  // And if no information is available we use a generic block
					$this->_targetBlock = new Block();
				}
			}
		}
		return $this->_targetBlock;
	}

	function parseRequest() {
		global $_REQUEST;
		$fields = parent::parseRequest();

		if (isset($_REQUEST['parentId'])) {
			$fields['parentId'] = $_REQUEST['parentId'];
		}

		return $fields;
	}

	function onBlockSaved() {
		global $_REQUEST;
		$red = RedCMS::get();
		foreach ($_REQUEST as $p => $v) {
			if (strpos($p, 'redcms_link_') !== false) {
				$linkType = str_replace('redcms_link_', '', $p);
				if (isset($v)) {
					$linkStatement = $red->dbManager->query('SELECT *, redcms_block.id AS blockId' .
							' FROM ' . $red->_dbBlock .
							' LEFT JOIN ' . $red->_dbBlockXBlock .
							' ON blockId=' . $red->_dbBlock . '.id AND relationType=\'' . $linkType . '\'  WHERE redcms_block.id=' . $this->_targetBlock->id);
					$linkTuple = $linkStatement->fetch(PDO::FETCH_ASSOC);
					$linkTuple['relationType'] = $linkType;
					$linkTuple['subBlockId'] = $v;
					$link = new BlockXBlock($linkTuple);
					$link->save();
				}
			}
		}
	}

	function getFormFields() {

		$fields = parent::getFormFields();

		if ($this->_targetBlock->parentId) {
			$fields[] = ['name' => 'parentId', 'type' => 'HiddenField', 'value' => '' . $this->_targetBlock->parentId];
		}

		foreach ($fields as &$f) {
			if (strpos($f['name'], 'redcms_link_') !== false) {
				$linkType = str_replace('redcms_link_', '', $f['name']);
				$targetBlock = $this->_targetBlock->getLinkedBlock($linkType);
				if ($targetBlock) {
					$f['value'] = '' . $targetBlock->id;
				}
			}
		}
		return $fields;
	}

}

class EditBlockPositionFormBlock extends Block { //extends EditBlockFormBlock {

	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)) {
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') { // If we are editing an existing block, we retrieve it
				$this->_targetBlock = BlockManager::getBlockById($_REQUEST['id']);
			} else {
				$this->targetBlock = null;
			}
		}
		return $this->_targetBlock;
	}

	function moveField($values) {
		$rs = RedCMS::get()->dbManager->Execute($sql);
		//		$this->log($sql);
		return $rs;
	}

	function recursivePropagation($cPos, $delta, $fields) {
		$red = RedCMS::get();

		$stat = $red->dbManager->prepare('SELECT id FROM redcms_block WHERE number1=? AND parentId=? AND id!=? AND id!=? LIMIT 0,1');
		$fields[0] = $cPos;

		if ($stat->execute($fields)) {
			$tuples = $stat->fetchAll();
			if (!empty($tuples)) {
				$this->recursivePropagation($cPos + $delta, $delta, $fields);

				$fields[0] = $cPos + $delta;
				$fields[4] = $cPos;
				$stat = $red->dbManager->prepare('UPDATE redcms_block SET number1=? WHERE parentId=? AND id!=? AND id!=? AND number1=?');
				$stat->execute($fields);
			}
		}
	}

	function render() {
		if (isset($_REQUEST['redaction'])) {  //Form has been sent for submission
			$red = RedCMS::get();
			$ret = ['result' => 'error', 'msg' => 'Form unsuccessfully saved.'];
			$targetBlock = $this->getTargetBlock();

			$targetBlock->set('parentId', $_REQUEST['parentId']);

			if (isset($_REQUEST['targetId'])) {   //There is a target, we move the block just after the target
				$refBlock = BlockManager::getBlockById($_REQUEST['targetId']);
				$position = $refBlock->number1;
				if ($position === null) { //HACK If there is no position, positions are corrupted, we reset them.
					$stat = $red->dbManager->prepare('UPDATE redcms_block SET number1=0 WHERE parentId=?');
					$stat->execute([$targetBlock->parentId]);
					$position = 0;
				}
				$fields = ['', $targetBlock->parentId, $targetBlock->id, $refBlock->id];
				$this->recursivePropagation($position, -1, $fields);
				$this->recursivePropagation($position + 1, 1, $fields);

				$targetBlock->set('number1', $position + 1);
				if ($targetBlock->save()) {
					$ret = ['result' => 'success', 'msg' => 'Changes have been made.'];
				}
			} else {   // No target, we move the block in the first position
				$stat = $red->dbManager->prepare('SELECT MIN(number1) FROM redcms_block WHERE parentId=?');
				$stat->execute([$targetBlock->parentId]);
				$r = $stat->fetchAll(PDO::FETCH_NUM);
				$position = $r[0][0];
				if (!$position) {
					$position = 0;
				} else {
					$position = $position - 1;
				}
				$targetBlock->set('number1', $position);
				if ($targetBlock->save()) {
					$ret = ['result' => 'success', 'msg' => 'Changes have been made.'];
				}
			}
			echo json_encode($ret);
		} else {
			// FIXME Better error handling here
			die('Cannot render this block');
		}
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
		$stat = $red->dbManager->query('SELECT *, redcms_group.id AS idGroup' .
				' FROM ' . $red->_dbGroup .
				' LEFT JOIN ' . $red->_dbUserXGroup .
				' ON idGroup=' . $red->_dbGroup . '.id AND idUser=' . $userId);
		return $stat->fetchAll(PDO::FETCH_ASSOC);
	}

	function parseRequest() {
		global $_REQUEST;
		$fields = parent::parseRequest();
		if (isset($_REQUEST['redaction'])) {  // Form has been sent for submission
			foreach ($this->getGetGroupMemberShipByUser($this->getTargetBlock()->id) as $g) { // We loop through the rights to select the one corresponding to 
				$isAMember = (isset($_REQUEST['membership_' . $g['idGroup']]));
				if ($isAMember && $g['id'] == '') {
					$g['idUser'] = $this->_targetBlock->id;  // For new tuples, we set the target id	
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

	function getFormFields() {
		die("Function not yet implemented.");
	}

	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)) {
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
		return $redCMS->dbManager->query('SELECT *, redcms_group.id AS idGroup ' .
						' FROM ' . $redCMS->_dbGroup .
						' LEFT JOIN ' . $redCMS->_dbGroupXBlock .
						' ON idGroup=' . $redCMS->_dbGroup . '.id AND idBlock=' . $blockId)->fetchAll(PDO::FETCH_ASSOC);
	}

	function parseRequest() {
		//echo 'EditRightsFormBlock.parseRequest()';
		global $_REQUEST;
		$fields = parent::parseRequest();

		if (isset($_REQUEST['redaction'])) {   // Form has been sent for submission
			$fields['read'] = (isset($_REQUEST['read'])) ? 1 : 0;
			$fields['write'] = (isset($_REQUEST['write'])) ? 1 : 0;
			$fields['publicread'] = (isset($_REQUEST['publicread'])) ? 1 : 0;
			$fields['publicwrite'] = (isset($_REQUEST['publicwrite'])) ? 1 : 0;

			foreach ($this->getRightsByGroup($this->getTargetBlock()->id) as $g) { // We loop through the rights to select the one corresponding to 
				$r = (isset($_REQUEST['read_' . $g['idGroup']])) ? 1 : 0;
				$w = (isset($_REQUEST['write_' . $g['idGroup']])) ? 1 : 0;
				echo $r, 's', $w;
				if ($r || $w || $g['id'] != '') {
					$g['idBlock'] = $this->_targetBlock->id;  // For new tuples, we set the target id	
					$g['read'] = ($r) ? '1' : '0';
					$g['write'] = ($w) ? '1' : '0';
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
	function getFormFields() {
		$fields = [];

		$this->getTargetBlock();
		$fields[] = ['name' => 'id', 'type' => 'HiddenField', 'value' => '' . $this->_targetBlock->id];
		$fields[] = ['name' => 'publicread', 'type' => 'CheckboxField', 'label' => 'Public read', 'checked' => $this->_targetBlock->publicread === 1];
		$fields[] = ['name' => 'publicwrite', 'type' => 'CheckboxField', 'label' => 'Public write', 'checked' => $this->_targetBlock->publicwrite === 1];
		$fields[] = ['name' => 'read', 'type' => 'CheckboxField', 'label' => 'Registered user read', 'checked' => $this->_targetBlock->read === 1];
		$fields[] = ['name' => 'write', 'type' => 'CheckboxField', 'label' => 'Registered user write', 'checked' => $this->_targetBlock->write === 1];

		foreach ($this->getRightsByGroup($this->_targetBlock->id) as $g) { //we loop through the rights to select the one corresponding to 
			if (!isset($g['read'])) {
				$g['read'] = 0;
				$g['write'] = 0;
			}
			$fields[] = ['name' => $g['name'] . '_read', 'type' => 'CheckboxField', 'label' => $g['name'] . ' read', 'checked' => $g['read'] === 1];
			$fields[] = ['name' => $g['name'] . '_write', 'type' => 'CheckboxField', 'label' => $g['name'] . ' write', 'checked' => $g['write'] === 1];
		}

		$fields[] = ['name' => 'redaction', 'type' => 'SubmitButton', 'value' => 'Submit'];
		return $fields;
	}

	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)) {
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
		if (!isset($this->_targetBlock)) {
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
				$this->_targetBlock = UserManager::getGroupById($_REQUEST['id']);
			} else {
				$this->_targetBlock = new Group();
			}
		}
		return $this->_targetBlocks;
	}

}

class EditUserFormBlock extends EditDBFormBlock {

	function getTargetBlock() {
		global $_REQUEST;
		if (!isset($this->_targetBlock)) {
			if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
				$this->_targetBlock = UserManager::getUserById($_REQUEST['id']);
			} else {
				$this->_targetBlock = new User();
			}
		}
		return $this->_targetblock;
	}

	function onBlockSaved() {
		RedCMS::get()->sessionManager->refreshCurrentUser();
	}

}

class EditCurrentUserFormBlock extends EditUserFormBlock {

	function getTargetBlock() {
		if (!isset($this->_targetBlock)) {
			$redCMS = RedCMS::get();
			$this->_targetBlock = $redCMS->sessionManager->getCurrentUser();
		}
		return $this->_targetblock;
	}

}
