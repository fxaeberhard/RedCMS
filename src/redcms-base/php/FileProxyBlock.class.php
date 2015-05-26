<?php

/*
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 * 
 * @deprecated
 */

class FileProxyBlock extends Block {
	
}

class ComboBlock extends FileProxyBlock {

	function renderHeaders() {

		$queryString = getenv('QUERY_STRING') ? urldecode(getenv('QUERY_STRING')) : '';
		'';
		$contentType = strpos($queryString, '.js') ? 'application/x-javascript' : 'text/css';
		header('Content-Type: ' . $contentType);

		// Send headers with cache controle activated
		$expires = 60 * 60 * 24 * 14;
		$expirationDate = gmdate('D, d M Y H:i:s', time() + $expires);

		header('Pragma: public');
		header('Cache-Control: public, maxage=' . $expires);
		header('Expires: ' . $expirationDate . ' GMT');
		header('Last-Modified: ' . $expirationDate . ' GMT');
		header('Vary: Accept-Encoding');
		//header_remove('Vary');
		// No cache headers
		//header("Expires: 0"); 
		//header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		//header("Cache-Control: private", false); // required for certain browsers 
		//ob_start("ob_gzhandler");
	}

	function render() {
		$redCMS = RedCMS::getInstance();

		$queryString = getenv('QUERY_STRING') ? urldecode(getenv('QUERY_STRING')) : '';
		$files = explode('&', $queryString);

		//Detect and load the required components now
		foreach ($files as $f) {
			$f = substr($f, 1);
			require($redCMS->fullpath . $f);
		}
	}

}
