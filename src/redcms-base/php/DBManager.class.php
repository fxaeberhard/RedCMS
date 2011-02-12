<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/
class DBManager extends PDO {
	
	/**
	 * FIXME litteral value instead of PDO::MYSQL_ATTR_INIT_COMMAND only to fix a bug in php 5.3 (or is it only in EasyPHP??)
	 * 
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 */
	function DBManager($dsn, $username, $password) {
		//parent::__construct($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
		parent::__construct($dsn, $username, $password, array(1002 => 'SET NAMES \'UTF8\''));
	}
}
?>