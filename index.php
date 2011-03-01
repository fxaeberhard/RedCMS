<?php
require('redcms-include.php');

$redConfig = array(
	'path' => '/RedCMS2/',
	'smtpMode' => true,
	'smtpHost' => 'mail.red-agent.com',
	'smtpPort' => 25,
	'smtpAuth' => true,
	'smtpUsername' => 'fx@red-agent.com',
	'smtpPassword' => 'fxmail01'
);

$redCMS = RedCMS::getInstance();
$redCMS->init($redConfig, 'mysql:host=localhost;dbname=redcms_default;', 'root', '');
$redCMS->render();

/*
echo '<pre>';
print_r($redCMS->dbManager->_queries);
*/
?>