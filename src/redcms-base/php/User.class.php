<?php
class User extends Tuple {
	var $groups;
	
	var $_dbFields = array('name', 'surname', 'password', 'email', 'userName', 'text1', 'anniversary',
		'profession', 'adress', 'adress_zip', 'adress_city', 'adress_country', 'pPhone', 'prPhone', 'poPhone', 'fax',
		'skypeCtct', 'icqCtct', 'aimCtct', 'yahooCtct', 'society', 'adresspro', 'adresspro_zip', 'adresspro_city');
	var $_dbTable = 'redcms_user';
	
	function getLabel() {
		if ($this->name) return $this->name.' '.$this->surname;
		else return $this->userName;
	}
	
}
class LoggedUser extends User {
	
}
class Guest extends User {
	function Guest() {
		parent::__construct();
		$this->fields['userName'] = 'Guest';
	}
}
?>