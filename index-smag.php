<?php

require('redcms-include.php');
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$redConfig = [
	'pageTemplate' => 'page-smag.tpl',
	'defaultLang' => 'fr',
	'adminMail' => 'contact@smagonline.ch',
	'windowTitleSuffix' => ' - smagonline.ch',
	'keywordSuffix' => 'société anesthésistes genevois smag anesthesist',
	'mailFooter' => '<br><br><hr style="width:100%">SMAG Société des Médecins Anesthésistes Genevois<br><a href="http://www.smagonline.ch">www.smagonline.ch</a><br> <a href="mailto:contact@smagonline.ch">contact@smagonline.ch</a>'
		//	'smtpMode' => true,
		//	'smtpHost' => '',
		//	'smtpPort' => 25,
		//	'smtpAuth' => true,
		//	'smtpUsername' => '',
		//	'smtpPassword' => '',
];

$redCMS = RedCMS::get();

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$redConfig['path'] = '/RedCMS/';
	$redCMS->init($redConfig, 'mysql:host=localhost;dbname=redcms_smag;', 'root', '');
} else {
	$redCMS->init($redConfig, 'mysql:host=mysql.smagonline.ch;dbname=smagonlinech5;', 'dbuser2', 'dbpass');
}


if ($redCMS->currentBlock) {
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
if ($redCMS->paramManager->hasMore()) {
	$nBlock = BlockManager::getBlocksBySelect('text1=?', [$redCMS->paramManager->current()]);
	if (!empty($nBlock)) {
		$redCMS->currentHierarchy[] = $nBlock[0];
	}
}

$redCMS->render();
