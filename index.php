<?php

/**
 * RedCMS default index file
 */
require('redcms-include.php');

$config = [
	'adminMail' => 'fx@red-agent.com',
	'windowTitleSuffix' => ' - RedCMS',
	'stylesheets' => ["src/redcms-base/assets/sample.css"]
	//'googleAnalyticsId' => 'UA-12224039-2',
	// 'pageTemplate' => 'page-default.tpl',
];

$redCMS = RedCMS::get();

//$redCMS->init($config, 'mysql:host=localhost;dbname=redcms;', 'root', '');
if (RedCMS::isLocalhost()) {
	$config['path'] = '/edsa-Work/RedCMS/';
	$redCMS->init($config, 'mysql:host=localhost;dbname=redcms_smag;', 'root', '');
} else {
	$redCMS->init($config, 'mysql:host=cajx.myd.infomaniak.com;dbname=cajx_redagentcom4;', 'cajx_redadmin', '78hzu45e');
}

$redCMS->render();
