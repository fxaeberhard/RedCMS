<?php
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
if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$redConfig['path'] = '/RedCMS2/';
	$redCMS->init($redConfig, 'mysql:host=localhost;dbname=redcms_default;', 'root', '');
} else {
	$redCMS->init($redConfig, 'mysql:host=mysql.red-agent.com;dbname=redagentcom4;', 'redadmin', '78hzu45e');
}


$redCMS->render();

/*
 if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$db = array('root', '', 'localhost', 'redcms_default');
	$path='/RedCMS/';
}else {
	$db = array('dbuser', 'dbpass','mysql.smagonline.ch', 'smagonlinech3');
	$path = '/';
}
$redCMS = new RedCMS($path, $db[0], $db[1],$db[2],$db[3]);

$redCMS->currentLang = 'fr';
require('redcms-config.php');

$redCMS->headerManager->addModule(array("smag" => array(
        "name" => 'smag',
        "type" => 'css',
        "fullpath" => $redCMS->host.$redCMS->path.'modules/src/smag/assets/smag.css', 
		"path" => "smag/assets/smag.css",
		"requires" => array( "menu")
)));
 */


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