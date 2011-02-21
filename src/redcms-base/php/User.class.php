<?php
class User {
	var $groups;
	var $fields = array();
	var $id;
	
	static $_dbFields = array('name', 'surname', 'password', 'email', 'userName', 'text1', 'anniversary',
		'profession', 'adress', 'adress_zip', 'adress_city', 'adress_country', 'pPhone', 'prPhone', 'poPhone', 'fax',
		'skypeCtct', 'icqCtct', 'aimCtct', 'yahooCtct', 'society', 'adresspro', 'adresspro_zip', 'adresspro_city');
	
	function User($fields=array()) {
		if (!isset($fields['id'])) $fields['id'] = '';
		$this->fields = $fields;
		$this->id = $fields['id'];
	}
	// *** Fields managment methods *** //
	function get($f) {
		if (isset($this->fields[$f])) return $this->fields[$f];
		return null;
	}
	
	function save(){
		global $redCMS;
		
		$values = array();
		$cols = array();
		foreach (User::$_dbFields as $f){
			if (isset($this->fields[$f])) {
				
				$insertCols1[] = $f;
				$insertCols2[] = '?';
				$updateCols[] = $f.'=?';
				$values[] = $this->fields[$f];
			}
		}
		if (is_numeric($this->fields['id'])){
			$query = 'UPDATE '.$redCMS->_dbUser.' SET '.implode(',', $updateCols).' WHERE id = '.$this->id;
		} else {
			$query = 'INSERT INTO '.$redCMS->_dbUser.' ('.implode(',', $insertCols1).') VALUES ('.implode(',', $insertCols2).')';
		}
		$statement = $redCMS->dbManager->prepare($query);
		return $statement->execute($values);
	}
	function delete(){
		global $redCMS;
		$query = 'DELETE FROM '.$redCMS->_dbUser.' WHERE id=? LIMIT 1';
		$statement = $redCMS->dbManager->prepare($query);
		return $statement->execute(array($this->fields['id']));
	}
}
class LoggedUser extends User {
	
}
class Guest extends User {
	function Guest() {
		parent::User(array());
		$this->name = 'Guest';
	}
}

?>