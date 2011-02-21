<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

class RedCMS {
	var $defaultConfg = array(
		'path' => '/',
		'homePageId' => 3,
		'defaultLang' => 'en',
		'headerTemplate' => 'header-default.tpl',
		'footerTemplate' => 'footer-default.tpl',
		'charset' => 'UTF-8',
		'debugMode' => false,
		'windowTitleSuffix'=>'',
		'keywordSuffix' => '',
		'adminMail'=>'fx@red-agent.com',
		'mailFooter' => '',
		// 'cacheEnabled'=> 1,
		// 'addingSlashServer'=> 1,
		// 'defaultPictureWidth' => 'x'
	);

	var $version = 0.1;
	
	/***************************************All utilities objects *******************/
	var $sessionManager;
	var $dbManager;
	var $paramManager;
	var $headerManager;
	//var $cacheManager;
	var $logger;
	
	/***************************************Working variables*************************/
	var $config;
	var $lang;
	var $path;
	var $fullpath;
	var $currentBlock;
	
	/***************************************DATABASE TABLE DECLARATION ****************/
	var $_dbBlock = 'redcms_block';
	var $_dbBlockXBlock = 'redcms_blockxblock';
	var $_dbGroup = 'redcms_group';
	var $_dbGroupXBlock = 'redcms_groupxblock';
	var $_dbRight = 'redcms_rights';
	var $_dbUser = 'redcms_user';
	var $_dbUserXGroup = 'redcms_userxgroup';
	
	function RedCMS($config, $dsn, $username, $password) {
		$GLOBALS['redCMS'] = $this;										//Instantiate a global reference to the RedCMS

		$this->config = array_merge($this->defaultConfg, $config);
	
		$this->path = $this->config['path'];
		$this->fullpath = $_SERVER['DOCUMENT_ROOT'].$this->path;
		$this->host = 'http://'.$_SERVER['HTTP_HOST'];
		
		$this->dbManager = new DBManager( $dsn, $username, $password );
		$this->paramManager = new ParamManager();
		$this->sessionManager = new SessionManager();
	}
	
	/**
	 * TODO
	 * + handle the page not found condition with the corresponding page name. 
	 *	
	 */
	function render() {
		// First retrive the lang of the current page if available
		$this->lang = ($this->paramManager->hasMore())?$this->paramManager->next():$this->config['defaultLang'];
		// Then retrieves the page parameter 
		$currentBlockParam = ($this->paramManager->hasMore())?$this->paramManager->next():$this->config['homePageId'];
		
		if (is_numeric($currentBlockParam)) {							// If the parameter is a number, use it as an id
			$this->currentBlock = BlockManager::getBlockById($currentBlockParam);
		} else {														// Otherwise use the link
			$this->currentBlock = BlockManager::getBlockBySelect('link = ?', array($currentBlockParam));
		}
		
		if (isset($this->currentBlock)) {								// If the block was correctly pulled
			$this->currentBlock->render();		 						// we render it
		} else {
			die('Page Not Found');
		}		
	}
}
?>