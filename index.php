<?php

/**
 * RedCMS default index file
 */
require('redcms-include.php');

$redConfig = [
	'pageTemplate' => 'page-default.tpl',
	'adminMail' => 'fx@red-agent.com',
	'windowTitleSuffix' => ' - RedCMS',
	'stylesheets' => ["src/redcms-base/assets/sample.css"]
		//'googleAnalyticsId' => 'UA-12224039-2',
];

$redCMS = RedCMS::get();

//$redCMS->init($redConfig, 'mysql:host=localhost;dbname=redcms_default;', 'root', '');

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$redConfig['path'] = '/RedCMS/';
	$redCMS->init($redConfig, 'mysql:host=localhost;dbname=redcms_default;', 'root', '');
} else {
	$redCMS->init($redConfig, 'mysql:host=cajx.myd.infomaniak.com;dbname=redagentcom4;', 'cajx_red', 'mi8ui7io9');
}

$redCMS->render();
