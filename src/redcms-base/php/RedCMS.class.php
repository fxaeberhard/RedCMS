<?php

/* RedCMS
 * 
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 */

/**
 * RedCMS base class
 * Singleton
 *
 */
class RedCMS {

	var $defaultConfg = array(
		'path' => '/',
		'homePageId' => 3,
		'notFoundPageId' => 22,
		'accessRestrictedPageId' => 23,
		'defaultPageTemplate' => 'page-default.tpl',
		'defaultLang' => 'en',
		'availableLang' => array('en'),
		'charset' => 'utf-8',
		'debugMode' => false,
		'windowTitleSuffix' => '',
		'keywordSuffix' => '',
		'adminMail' => 'fx@red-agent.com',
		'mailFooter' => '<br /><br/><hr>Sent via RedCMS',
		'publicFilePath' => 'files/public/',
		'privateFilePath' => 'files/private/',
		'smtpMode' => false,
		'smtpHost' => '',
		'smtpPort' => '',
		'smtpAuth' => false,
		'smtpUsername' => '',
		'smtpPassword' => '',
		'version' => '0.2.2',
		'cacheEnabled' => false
	);

	/*	 * *************************************All utilities objects ****************** */
	var $sessionManager;
	var $dbManager;
	var $paramManager;
	//var $logger;

	/*	 * *************************************Working variables************************ */
	var $config;
	var $lang;
	var $path;
	var $fullpath;
	var $currentBlock;
	var $currentHierarchy = array();

	/*	 * *************************************DATABASE TABLE DECLARATION *************** */
	var $_dbBlock = 'redcms_block';
	var $_dbBlockXBlock = 'redcms_blockxblock';
	var $_dbGroup = 'redcms_group';
	var $_dbGroupXBlock = 'redcms_groupxblock';
	var $_dbRight = 'redcms_rights';
	var $_dbUser = 'redcms_user';
	var $_dbUserXGroup = 'redcms_userxgroup';

	function init($config, $dsn, $username, $password) {
		$this->config = array_merge($this->defaultConfg, $config);

		$this->path = $this->config['path'];
		//$this->fullpath = $_SERVER['DOCUMENT_ROOT'].$this->path;
		$this->fullpath = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
		$this->host = 'http://' . $_SERVER['HTTP_HOST'];

		$this->dbManager = new DBManager($dsn, $username, $password);
		$this->paramManager = new ParamManager();
		$this->sessionManager = new SessionManager();


		$cParam = $this->paramManager->next();

		if ($cParam && ($cParam == 'fr' || $cParam == 'en')) { // First retrive the lang of the current page if available
			$this->lang = $cParam;
			$cParam = $this->paramManager->next();	// Then retrieves the page parameter 
		} else {
			$this->lang = $this->config['defaultLang'];
		}

		if ($cParam == null)
			$cParam = $this->config['homePageId'];   // If there is no param available, we use the homepage id instead

		if (is_numeric($cParam)) {	 // If the parameter is a number, use it as an id
			$this->currentBlock = BlockManager::getBlockById($cParam);
		} else {	  // Otherwise use the link
			$this->currentBlock = BlockManager::getBlockBySelect('link = ?', array($cParam));
		}
		$this->currentHierarchy[] = $this->currentBlock;
	}

	/**
	 * TODO
	 * + handle the page not found condition with the corresponding page name. 
	 * 	
	 */
	function render() {

		//ob_implicit_flush(true);
		ob_start('ob_gzhandler');
		header("Content-Type: text/html; charset=" . $this->config['charset']);

		if ($this->currentBlock) {	 // If the block was correctly pulled
			if ($this->currentBlock->canRead()) {
				$this->currentBlock->renderHeaders();
				$this->currentBlock->render();	// we render it
			} else {
				die('Authorization refusedssss');
			}
		} else {
			die('Page Not Found');
		}
	}

	//	***	Singleton methods *** //
	private static $instance;   // Hold an instance of the class

	private function __construct() {
		
	}

// A private constructor; prevents direct creation of object

	public static function getInstance() {   // The singleton method
		return RedCMS::get();
	}

	public static function get() {	 // The singleton method
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function __clone() {	// Prevent users to clone the instance
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}

}

?>