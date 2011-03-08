<?php
/**
RedCMS - 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/
class UserManager {
	static function getUserById($blockId) {
		if ($blockId == '0'){
			return new Guest();
		}
		$users = UserManager::getUsersBySelect('id=?', array($blockId));
		if (!empty($users)) return $users[0];
		else return null;
	}
	static function getUsersByGroupId($groupId) {
		$redCMS = RedCMS::get();
		$statement = $redCMS->dbManager->prepare('SELECT * FROM '.$redCMS->_dbUser.
			' JOIN '.$redCMS->_dbUserXGroup.' ON redcms_user.id = idUser AND idGroup=?');
		return UserManager::getUsersByStatement($statement, array($groupId));
	}
	static function &getUserBySelect($select, $values = array()) {
		$users = UserManager::getUsersBySelect($select, $values);
		return $users[0];
	}
	
	static function getUsersBySelect($select, $values = array()) {
		$redCMS = RedCMS::get();
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
			$users[] = new LoggedUser($field);
		}
		return $users;
	}
	/*static function getGroupsBySelect($select, $values){
		$redCMS = RedCMS::get();
		$stat = $redCMS->dbManager->prepare('SELECT * FROM '.$redCMS->_dbGroup.' WHERE '.$select);
		if ($stat->execute( $values ){
			$g = UserManager::getGroupsByFields($stat->fetchAll(PDO::FETCH_ASSOC));
			return $g[0];
		} else return null;
	}*/
	static function getGroupsByUserId($userId) {
		$redCMS = RedCMS::get();
		$stat = $redCMS->dbManager->prepare('SELECT *, idGroup as id FROM '.$redCMS->_dbGroup.
			' JOIN '.$redCMS->_dbUserXGroup.' on redcms_group.id = idGroup AND idUser =?');
		if ($stat->execute(array($userId))) {
			$g = UserManager::getGroupsByFields($stat->fetchAll(PDO::FETCH_ASSOC));
			return $g;
		} else return array();
	}
	static function getGroupById($id){
		$redCMS = RedCMS::get();
		$stat = $redCMS->dbManager->prepare('SELECT * FROM '.$redCMS->_dbGroup.' WHERE id=?');
		if ($stat->execute(array($id))){
			$g = UserManager::getGroupsByFields($stat->fetchAll(PDO::FETCH_ASSOC));
			return $g[0];
		} else return null;
	}
	static function getGroups(){
		$redCMS = RedCMS::get();//int $PDO::FETCH_CLASS , string $classname
		return UserManager::getGroupsByFields($redCMS->dbManager->query('SELECT * FROM '.$redCMS->_dbGroup)->fetchAll(PDO::FETCH_ASSOC));
	}
	static function &getGroupsByFields($fields) {
		$groups = array();
		foreach( $fields as &$field){
			$groups[] = new Group($field);
		}
		return $groups;
	}
}
class UserManagerBlock extends TreeStructure {	
	function getChildBlocks(){
		$redCMS = RedCMS::get();
		if ($redCMS->paramManager->hasMore()){
			$userId = $redCMS->paramManager->next();
			$users = UserManager::getUsersBySelect('id=? ORDER BY name', array($userId));
			// FIXME This does not work since hierarchy is already displayed
			$redCMS->currentHierarchy[] = $users[0];
			return $users;
		} else {
			return UserManager::getUsersBySelect('1 ORDER BY name', array());
		}
	}
}
class CurrentUserManagerBlock extends TreeStructure {	
	function getChildBlocks(){
		$redCMS = RedCMS::get();
		return array($redCMS->sessionManager->getCurrentUser());
	}
}
class GroupManagerBlock extends TreeStructure {	
	function getChildBlocks(){
		return UserManager::getGroups();
	}
}
?>