<?php

/**
  RedCMS -
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */
class UserManager {

	static function getUserById($blockId) {
		if ($blockId == '0') {
			return new Guest();
		}
		$users = UserManager::getUsersBySelect('id=?', [$blockId]);
		if (!empty($users)) {
			return $users[0];
		} else {
			return null;
		}
	}

	static function getUsersByGroupId($groupId) {
		$redCMS = RedCMS::get();
		$statement = $redCMS->dbManager->prepare('SELECT * FROM ' . $redCMS->_dbUser .
				' JOIN ' . $redCMS->_dbUserXGroup . ' ON redcms_user.id = idUser AND idGroup=?');
		return UserManager::getUsersByStatement($statement, [$groupId]);
	}

	static function &getUserBySelect($select, $values = []) {
		$users = UserManager::getUsersBySelect($select, $values);
		return $users[0];
	}

	static function getUsersBySelect($select, $values = []) {
		$redCMS = RedCMS::get();
		$statement = $redCMS->dbManager->prepare('SELECT * FROM ' . $redCMS->_dbUser . ' WHERE ' . $select);
		return UserManager::getUsersByStatement($statement, $values);
	}

	static function getUsersByStatement($statement, $values = []) {
		if ($statement->execute($values)) {
			$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
			$users = UserManager::getUserByFields($rows);
			return $users;
		} else {
			$users = [];
			return $users;
		}
	}

	static function &getUserByFields($fields) {
		$users = [];
		foreach ($fields as &$field) {
			$users[] = new LoggedUser($field);
		}
		return $users;
	}

	/* static function getGroupsBySelect($select, $values){
	  $redCMS = RedCMS::get();
	  $stat = $redCMS->dbManager->prepare('SELECT * FROM '.$redCMS->_dbGroup.' WHERE '.$select);
	  if ($stat->execute( $values ){
	  $g = UserManager::getGroupsByFields($stat->fetchAll(PDO::FETCH_ASSOC));
	  return $g[0];
	  } else return null;
	  } */

	static function getGroupsByUserId($userId) {
		$redCMS = RedCMS::get();
		$stat = $redCMS->dbManager->prepare('SELECT *, idGroup as id FROM ' . $redCMS->_dbGroup .
				' JOIN ' . $redCMS->_dbUserXGroup . ' on redcms_group.id = idGroup AND idUser =?');
		if ($stat->execute([$userId])) {
			$g = UserManager::getGroupsByFields($stat->fetchAll(PDO::FETCH_ASSOC));
			return $g;
		} else {
			return [];
		}
	}

	static function getGroupById($id) {
		$redCMS = RedCMS::get();
		$stat = $redCMS->dbManager->prepare('SELECT * FROM ' . $redCMS->_dbGroup . ' WHERE id=?');
		if ($stat->execute([$id])) {
			$g = UserManager::getGroupsByFields($stat->fetchAll(PDO::FETCH_ASSOC));
			return $g[0];
		} else {
			return null;
		}
	}

	static function getGroups() {
		$redCMS = RedCMS::get(); //int $PDO::FETCH_CLASS , string $classname
		return UserManager::getGroupsByFields($redCMS->dbManager->query('SELECT * FROM ' . $redCMS->_dbGroup)->fetchAll(PDO::FETCH_ASSOC));
	}

	static function &getGroupsByFields($fields) {
		$groups = [];
		foreach ($fields as &$field) {
			$groups[] = new Group($field);
		}
		return $groups;
	}

}

class UserManagerBlock extends TreeStructure {

	function getChildBlocks($orderBy = NULL) {
		$redCMS = RedCMS::get();
		$orderBy = ($orderBy) ? ' ORDER BY ' . $orderBy : '';
		if ($redCMS->paramManager->hasMore()) {
			$userId = $redCMS->paramManager->next();
			$users = UserManager::getUsersBySelect("id=? $orderBy", [$userId]);
			// FIXME This does not work since hierarchy is already displayed
			$redCMS->currentHierarchy[] = $users[0];
			return $users;
		} else {
			return UserManager::getUsersBySelect("1 $orderBy", []);
		}
	}

	function getUsersByGroup() {
		$childs = $this->getChildBlocks("name");
		usort($childs, function ($a, $b) {
			if ($a->isAMember(10) && !$b->isAMember(10)) {
				return -1;
			} else if (!$a->isAMember(10) && $b->isAMember(10)) {
				return 1;
			} else if ($a->isAMember(11) && !$b->isAMember(11)) {
				return -1;
			} else if (!$a->isAMember(11) && $b->isAMember(11)) {
				return 1;
			}
			return $a->name > $b->name;
		});
		return $childs;
	}

}

class CurrentUserManagerBlock extends TreeStructure {

	function getChildBlocks($orderBy = NULL) {
		$redCMS = RedCMS::get();
		return [$redCMS->sessionManager->getCurrentUser()];
	}

}

class GroupManagerBlock extends TreeStructure {

	function getChildBlocks($orderBy = NULL) {
		return UserManager::getGroups();
	}

}
