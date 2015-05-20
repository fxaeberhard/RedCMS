<?php

/* RedCMS - Conversation
 * 
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

class ConversationBlock extends TreeStructure {

	var $_currentFields;

	function getChildBlocks($orderBy = null) {
		if (isset($this->_currentFields))
			return $this->_currentFields;
		else
			return parent::getChildBlocks($orderBy);
	}

	function render() {
		$redCMS = RedCMS::get();
		$param = $this->nextParam();
		if ($param) {
			$this->_currentFields = BlockManager::getBlocksBySelect("text1=?", array($param));
			$template = $this->getTemplate();
			$template->display($this->text5);
		} else
			parent::render();
	}

}

class Field extends Block {

	function canRead() {
		$parent = $this->parentBlock();
		if ($parent) {
			return $parent->canRead();
		} else {
			return false;
		}
	}

	function canWrite() {
		$parent = $this->parentBlock();
		if ($parent) {
			return $parent->canWrite();
		} else {
			return false;
		}
	}

}

class ConversationField extends Field {

	function getLabel() {
		if ($this->text1)
			return $this->text1;
		else
			return parent::getLabel();
	}

}

class EventField extends ConversationField {

	var $_dbFieldsMap = array('title' => 'text1', 'description' => 'longtext1');

}

class NewsField extends ConversationField {

	var $_dbFieldsMap = array('title' => 'text1', 'description' => 'longtext1');

}

class ReplyField extends ConversationField {

	var $_dbFieldsMap = array('title' => 'text1', 'description' => 'longtext1');

}

class TopicField extends ConversationField {

	var $_dbFieldsMap = array('title' => 'text1', 'description' => 'longtext1');

}

class DigestBlock extends TreeStructure {

	function getChildBlocks($orderBy = null) {
		$orderBy = ($orderBy) ? ' ORDER BY ' . $orderBy : '';
		return BlockManager::getBlocksBySelect("type in ('TopicField', 'ReplyField', 'NewsField', 'EventField') $orderBy LIMIT 0, 100", array());
	}

}

?>