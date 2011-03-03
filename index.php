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
//echo "<pre>";
//print_r($redCMS->dbManager->_queries);
//$stat = $redCMS->dbManager->query("UPDATE redcms_blockxblock SET subBlockId=230 WHERE subBlockId=120 AND id>110;");
/*
$stat = $redCMS->dbManager->query("UPDATE redcms_block SET parentId=2, template='page-smag.tpl' WHERE type='PageBLock';");
echo '<pre>';
//print_r($redCMS->dbManager->_queries);
*//*
$stat = $redCMS->dbManager->query("SELECT * FROM redcms_user WHERE id >99");
//$i = 0;

foreach ($stat->fetchAll(PDO::FETCH_ASSOC) as $f) {
	//print_r($f);
	
	$b = array();
	$b['idUser'] = $f['id'];
	$b['idBlock'] = 11;
	
	$bb = new UserXGroup($b);
	$bb->save();
	//$stat = $redCMS->dbManager->query("UPDATE redcms_blockxblock SET id2=".$i." WHERE id =".$f['id']." LIMIT 1 ;");
	//++$i;
}*/
?>