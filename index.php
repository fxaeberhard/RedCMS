<?php
require('redcms-include.php');

$redConfig = array(
	'path' => '/RedCMS2/'
);
$redCMS = new RedCMS($redConfig, 'mysql:host=localhost;dbname=redcms_default;', 'root', '');
$redCMS->render();
?>