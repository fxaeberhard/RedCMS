<?php
class User {
	var $groups;
	var $fields = array();
	function User($fields) {
		$this->fields = $fields;
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