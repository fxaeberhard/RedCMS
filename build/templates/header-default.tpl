<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Temporary title</title>
		<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?3.3.0/build/cssfonts/fonts-min.css&3.3.0/build/cssreset/reset-min.css&3.3.0/build/cssgrids/grids-min.css&3.3.0/build/cssbase/base-min.css" charset="utf-8" />
		
		<meta id="customstyles" />
		<link rel="stylesheet" type="text/css" href="{$redCMS->path}src/redcms-base/assets/default-skin.css" />
	</head>
	
	{$rootAdmin = [
			['widget' => 'OpenPanelAction', 
				'label' => '[root]Edit block', 
				'href' => ParamManager::getLink('210'),
				'action' => 'editCurrent'
			], ['widget' => 'OpenPanelAction', 
				'label' => '[root]Edit rights', 
				'href' => ParamManager::getLink('109'),
				'action' => 'editCurrent'
			], ['widget' => 'OpenPanelAction', 
				'label' => '[root]Add sibling', 
				'href' => ParamManager::getLink('210'),
				'action' => 'addSibling'
			], ['widget' => 'OpenPanelAction', 
			'label' => '[root]Add child', 
			'href' => ParamManager::getLink('210'),
			'action' => 'addChild'
			], ['widget' => 'DeleteBlockAction', 
				'label' => '[root]Delete', 
				'href' => ParamManager::getLink('103'),
				'action' => 'editCurrent'
			]]}
	
	<body class="yui3-skin-sam yui-skin-sam" redadmin="{htmlspecialchars(json_encode($rootAdmin))}"> 