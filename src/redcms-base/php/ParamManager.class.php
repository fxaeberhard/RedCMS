<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

class ParamManager {
	
	var $parameters = array();
	
	function ParamManager() {
		$this->init();	
	}
	function init() {	
		global $redCMS, $_SERVER;
		if (isset($_SERVER['REDIRECT_URL'])) {					// REDIRECT_URL is provided by Apache when a URL has been rewritten
			$redirUrl = $_SERVER['REDIRECT_URL'];
			if ($redCMS->path != '/') $redirUrl = str_replace($redCMS->path, '', $redirUrl);
			
			$args = explode('/', $redirUrl);
			foreach ($args as &$arg) {
				if ($arg != '') {
					$this->parameters[] = Utils::url_decode($arg);
				}
			}
		}
	}
	function hasMore(){
		return count($this->parameters) > 0;
	}
	function &current(){
		return $this->parameters[0];
	}
	function next(){
		return array_shift($this->parameters);
	}
	static function &getLink($param1= null, $param2= null, $param3= null, $param4=null){
		global $redCMS;
		$ret = $redCMS->path.$redCMS->lang."/";

		if ($param1) $ret .= Utils::url_encode($param1)."/";
		if ($param2) $ret .= Utils::url_encode($param2)."/";
		if ($param3) $ret .= Utils::url_encode($param3)."/";
		if ($param4) $ret .= Utils::url_encode($param4)."/";

		return $ret;
	}
}
?>