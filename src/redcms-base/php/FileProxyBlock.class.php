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
		$contentType = strpos($queryString, ".js") ? 'application/x-javascript' : 'text/css';
		
		header("Content-Type: ".$contentType);
		
		// Send header with right cache controle
		$expires = 60*60*24*14;
		//header("Pragma: public");
		//header("Cache-Control: maxage=".$expires);
		//header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
		//header("Last-Modified: ". gmdate('D, d M Y H:i:s', time()+$expires) ." GMT");
		
		//old
   		//header("Expires: 0"); 
    	//header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    	//header("Cache-Control: private",false); // required for certain browsers 
    	
		//Detect and load the required components now
		$yuiComponents = array();
		foreach ($files as $f) {
			$f = substr($f, 1);
			require($redCMS->fullpath.$f);
		}
	}
}