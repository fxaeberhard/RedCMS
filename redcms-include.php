<?php

/*
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

//print_r($_SERVER);
//$root = $_SERVER['DOCUMENT_ROOT'].str_replace('index.php', '', $_SERVER['PHP_SELF']);
$root = str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']);
$src = $root . 'src/';

require($root . 'lib/Smarty/libs/Smarty.class.php');
require($root . 'lib/phpmailer/class.phpmailer.php');
// require($root . 'lib/FirePHPCore/FirePHP.class.php');

require($src . 'redcms-base/php/RedCMS.class.php');
require($src . 'redcms-base/php/RedCMSMailer.class.php');
require($src . 'redcms-base/php/TemplateManager.class.php');
require($src . 'redcms-base/php/DBManager.class.php');
require($src . 'redcms-base/php/BlockManager.class.php');
require($src . 'redcms-base/php/ParamManager.class.php');
require($src . 'redcms-base/php/Utils.class.php');


require($src . 'redcms-base/php/Block.class.php');
require($src . 'redcms-base/php/PageBlock.class.php');
require($src . 'redcms-base/php/Action.class.php');
require($src . 'redcms-base/php/TreeStructure.class.php');
require($src . 'redcms-base/php/FileManager.class.php');
require($src . 'redcms-base/php/FileProxyBlock.class.php');
require($src . 'redcms-form/php/FormBlock.class.php');
require($src . 'redcms-form/php/MailFormBlock.class.php');
require($src . 'redcms-conversation/php/Conversation.class.php');
require($src . 'redcms-base/php/User.class.php');

require($src . 'redcms-base/php/UserManager.class.php');
require($src . 'redcms-base/php/SessionManager.class.php');
