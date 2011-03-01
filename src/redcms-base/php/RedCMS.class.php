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
		'defaultLang' => 'en',
		'headerTemplate' => 'header-default.tpl',
		'footerTemplate' => 'footer-default.tpl',
		'charset' => 'UTF-8',
		'debugMode' => false,
		'windowTitleSuffix'=>'',
		'keywordSuffix' => '',
		'adminMail'=>'fx@red-agent.com',
		'mailFooter' => '<br /><br/><hr>Sent via RedCMS',
		'publicFilePath' => 'files/public/',
		'privateFilePath' => 'files/private/',
		'smtpMode' => false,
		'smtpHost' => '',
		'smtpPort' => '',
		'smtpAuth' => false,
		'smtpUsername' => '',
		'smtpPassword' => '',
		'version' => '0.2.0',
		'cacheEnabled'=> false,
		// 'addingSlashServer'=> 1,
		// 'defaultPictureWidth' => 'x'
	);
	
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
	
	function init($config, $dsn, $username, $password) {
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
	//	***	Singleton methods *** //
	
    private static $instance;											// Hold an instance of the class
    
    private function __construct() {  }									// A private constructor; prevents direct creation of object

    public static function getInstance(){								// The singleton method
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }
 	public static function get(){								// The singleton method
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }
    public function __clone() {											 // Prevent users to clone the instance
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
}
?>