<?php
/**
RedCMS - 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/
class UserManager {
	static function getUserById($blockId) {
		$users = UserManager::getUsersBySelect('id=?', array($blockId));
		return $users[0];
	}
	
	static function &getUserBySelect($select, $values = array()) {
		$users = UserManager::getUsersBySelect($select, $values);
		return $users[0];
	}
	
	static function getUsersBySelect($select, $values = array()) {
		global $redCMS;
		$statement = $redCMS->dbManager->prepare('SELECT * FROM '.$redCMS->_dbUser.' WHERE '.$select);
		return UserManager::getUsersByStatement($statement, $values);
	}
	
	static function getUsersByStatement($statement, $values){
		if ($statement->execute($values)) {	
			$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$users = UserManager::getUserByFields($rows);
			return $users;
		} else {
			$users = array();
			return $users;
		}
	}

	static function &getUserByFields($fields) {
		$users = array();
		foreach( $fields as &$field){
			$users[] = new User($field);
		}
		return $users;
	}
	static function getGroups(){
		global $redCMS;
		return $redCMS->dbManager->query('SELECT * FROM '.$redCMS->_dbGroup)->fetchAll(PDO::FETCH_ASSOC);
	}
}
class UserManagerBlock extends TreeStructure {	
	function getChildBlocks(){
		return UserManager::getUsersBySelect('1', array());
	}
}
?>