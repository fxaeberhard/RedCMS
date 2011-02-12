<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

class BlockManager {
	static function getBlockById($blockId) {
		$blocks = BlockManager::getBlocksBySelect('id=?', array($blockId));
		return $blocks[0];
	}
	
	static function &getBlockBySelect($select, $values = array()) {
		$blocks = BlockManager::getBlocksBySelect($select, $values);
		return $blocks[0];
	}
	
	static function getBlocksBySelect($select, $values = array()) {
		global $redCMS;
		$statement = $redCMS->dbManager->prepare('SELECT * FROM '.$redCMS->_dbBlock.' WHERE '.$select);
		return BlockManager::getBlockByStatement($statement, $values);
	}
	
	static function getLinkedBlocks($blockId, $relationType) {
		global $redCMS;
		$statement = $redCMS->dbManager->prepare('SELECT * FROM '.$redCMS->_dbBlock.' JOIN '.$redCMS->_dbBlockXBlock
			." ON ".$redCMS->_dbBlock.".id = subBlockId"
			.' WHERE blockId=? AND relationType=?' );
		return BlockManager::getBlockByStatement($statement, array($blockId, $relationType));
	}
	
	static function getBlockByStatement($statement, $values){
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
		foreach( $fields as &$field){
			eval('$block = new '.$field['type'].'($field);');
			if (isset($block)) $blocks[] = $block;
		}
		return $blocks;
	}
}
?>