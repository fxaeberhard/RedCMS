<?php

/*
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

class BlockManager {

	//var $_blockCache = array();

	static function getBlockById($blockId) {
		$blocks = BlockManager::getBlocksBySelect('id=?', array($blockId));
		if (!empty($blocks))
			return $blocks[0];
		else
			return null;
	}

	static function getBlockBySelect($select, $values = array()) {
		$blocks = BlockManager::getBlocksBySelect($select, $values);
		if (!empty($blocks))
			return $blocks[0];
		else
			return null;
	}

	static function getBlocksBySelect($select, $values = array()) {
		$redCMS = RedCMS::getInstance();
		$statement = $redCMS->dbManager->prepare('SELECT * FROM ' . $redCMS->_dbBlock . ' WHERE ' . $select);
		return BlockManager::getBlockByStatement($statement, $values);
	}

	static function getLinkerBlocks($blockId, $relationType) {
		$redCMS = RedCMS::getInstance();
		$statement = $redCMS->dbManager->prepare('SELECT * FROM ' . $redCMS->_dbBlockXBlock . ' JOIN ' . $redCMS->_dbBlock
				. " ON " . $redCMS->_dbBlock . ".id = blockId"
				. ' WHERE subBlockId=? AND relationType=?');
		return BlockManager::getBlockByStatement($statement, array($blockId, $relationType));
	}

	static function getLinkedBlocks($blockId, $relationType) {
		$redCMS = RedCMS::getInstance();
		$statement = $redCMS->dbManager->prepare('SELECT * FROM ' . $redCMS->_dbBlockXBlock . ' JOIN ' . $redCMS->_dbBlock
				. " ON " . $redCMS->_dbBlock . ".id = subBlockId"
				. ' WHERE blockId=? AND relationType=?');
		return BlockManager::getBlockByStatement($statement, array($blockId, $relationType));
	}

	static function getBlockByStatement($statement, $values) {
		if ($statement->execute($values)) {
			$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$blocks = BlockManager::getBlocksByFields($rows);
			return $blocks;
		} else {
			$blocks = array();
			return $blocks;
		}
	}

	static function &getBlocksByFields($fields) {
		$blocks = array();
		foreach ($fields as &$field) {
			//eval('$block = new '.$field['type'].'($field);');				//PHP >=5.3.0
			$block = new $field['type']($field);	//PHP < 5.3.0

			if (isset($block)) {
				//if ($block->id != '') $_blockCache[$block->id] = $block;
				$blocks[] = $block;
			}
		}
		return $blocks;
	}

}

?>