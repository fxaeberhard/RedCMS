<?php
class User extends Tuple {
	var $_groups;
	
	var $_dbFields = array('name', 'surname', 'password', 'email', 'userName', 'text1', 'anniversary',
		'profession', 'adress', 'adress_zip', 'adress_city', 'adress_country', 'pPhone', 'prPhone', 'poPhone', 'fax',
		'skypeCtct', 'icqCtct', 'aimCtct', 'yahooCtct', 'society', 'adresspro', 'adresspro_zip', 'adresspro_city');
	var $_dbTable = 'redcms_user';
	
	function getLabel() {
		if ($this->name) return $this->name.' '.$this->surname;
		else return $this->userName;
	}
	function getGroups() {
		return $this->_groups;
	}
	function belongsToAnyGroup(){
		$this->getGroups();
		return (!empty($this->_groups));
	}
	function isAMember($groupId) {
		foreach ($this->getGroups() as $g) {
			if ($g->id == $groupId) return true;
		}
		return false;
	}
	function getGroupsQuery(){
		$ret = array();
		foreach ($this->getGroups() as $g) {
			$ret[] = $g->id;
		}
		return '('.implode(',', $ret).')';
	}
}
class LoggedUser extends User {
	function getGroups() {
		if (!isset($this->_groups)) {
			$this->_groups = UserManager::getGroupsByUserId($this->id);
		}
		return $this->_groups;
	}
}
class Guest extends User {
	function Guest() {
		parent::__construct();
		$this->fields['userName'] = 'Guest';
		$this->_groups = array();
	}
}
?>