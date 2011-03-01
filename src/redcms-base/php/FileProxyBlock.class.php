<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

class FileProxyBlock extends Block {

}
class ComboBlock extends FileProxyBlock {
	function render(){
		$redCMS = RedCMS::getInstance();
		
		$queryString = getenv('QUERY_STRING') ? urldecode(getenv('QUERY_STRING')) : '';
		$files = explode("&", $queryString);
		$contentType = strpos($queryString, ".js") ? 'application/x-javascript' : ' text/css';
		Header("content-type: ".$contentType);
		//Detect and load the required components now
		$yuiComponents = array();
		foreach ($files as $f) {
			$f = substr($f, 1);
			require($redCMS->fullpath.$f);
		}
	}
}