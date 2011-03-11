<?php
/**
 * RedCMS default index file
 */

require('redcms-include.php');


$redConfig = array(
	'path' => '/',
	'defaultPageTemplate' => 'page-default.tpl',
	'defaultLang' => 'en',
	'adminMail' => 'fx@red-agent.com',
	'windowTitleSuffix' => ' - RedCMS',
	'keywordSuffix' => '',
//	'mailFooter' => ''
);
$redCMS = RedCMS::getInstance();

$redConfig['path'] = '/RedCMS2/';
$redCMS->init($redConfig, 'mysql:host=localhost;dbname=redcms_default;', 'root', '');

$redCMS->render();

?>