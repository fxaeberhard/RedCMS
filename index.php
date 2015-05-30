<?php

/**
 * RedCMS default index file
 */
require('redcms-include.php');

$redConfig = [
	'defaultPageTemplate' => 'page-default.tpl',
	'defaultLang' => 'en',
	'adminMail' => 'fx@red-agent.com',
	'windowTitleSuffix' => ' - RedCMS',
	'keywordSuffix' => '',
	//'mailFooter' => '',
	//'path' => '/',
	"path" => "/RedCMS/"
];

$redCMS = RedCMS::get();

$redCMS->init($redConfig, 'mysql:host=localhost;dbname=redcms_default;', 'root', '');

$redCMS->render();
