<?php
require('redcms-include.php');

$redConfig = array(
	'path' => '/',
//	'smtpMode' => true,
//	'smtpHost' => '',
//	'smtpPort' => 25,
//	'smtpAuth' => true,
//	'smtpUsername' => '',
//	'smtpPassword' => '',
	'defaultPageTemplate' => 'page-default.tpl',
	'defaultLang' => 'fr',
	'adminMail' => 'contact@smagonline.ch',
	'windowTitleSuffix' => ' - smagonline.ch',
	'keywordSuffix' => 'société anesthésistes genevois smag anesthesist',
	'mailFooter' => '<br><br><hr style="width:100%">SMAG Société des Médecins Anesthésistes Genevois<br><a href="http://www.smagonline.ch">www.smagonline.ch</a><br> <a href="mailto:contact@smagonline.ch">contact@smagonline.ch</a>'
);

$redCMS = RedCMS::getInstance();

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$redConfig['path'] = '/RedCMS2/';
	$redCMS->init($redConfig, 'mysql:host=localhost;dbname=redcms_default;', 'root', '');
} else {
	$redCMS->init($redConfig, 'mysql:host=mysql.smagonline.ch;dbname=smagonlinech4;', 'dbuser', 'dbpass');
}


if ($redCMS->currentBlock){
	$cMenuItem = $redCMS->currentBlock->getLinkerBlocks('target');
	if (!empty($cMenuItem)) {
		$cMenuItem = $cMenuItem[0];
		$cMenuItem = $cMenuItem->parentBlock();
		while ($cMenuItem && $cMenuItem instanceof Action) {
			array_unshift($redCMS->currentHierarchy, $cMenuItem);
			$cMenuItem = $cMenuItem->parentBlock();
		}
	}
}
if ($redCMS->paramManager->hasMore()){
	$nBlock = BlockManager::getBlocksBySelect('text1=?', array($redCMS->paramManager->current()));
	if (!empty($nBlock)) $redCMS->currentHierarchy[] = $nBlock[0];
}

$redCMS->render();
?>