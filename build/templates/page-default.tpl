{* 
 *
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 * 
 *}{if !$reload}<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>{$this->getLabel()}{$redCMS->config['windowTitleSuffix']}</title>
		<meta http-equiv="content-type" content="text/html; charset={$redCMS->config['charset']}" />
		<meta name="DESCRIPTION" content="" />
		<meta name="KEYWORDS" content="{$redCMS->config['keywordSuffix']}" />     
		<meta name="robots" content="index, follow" />
		<meta name="contact" content="{$redCMS->config['adminMail']}" />
		<meta http-equiv="Content-Language" content="{$redCMS->lang}" />
		<meta name="Audience" content="General" />
		<meta name="Distribution" content="Global" />
		<meta name="revisit-after" content="30 days" />
		{*<meta name="expires" content="never" /> *}
		
		{block name="stylesheets"}
			<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?3.3.0/build/cssfonts/fonts-min.css&3.3.0/build/cssreset/reset-min.css&3.3.0/build/cssgrids/grids-min.css&3.3.0/build/cssbase/base-min.css" charset="utf-8" />
			<meta id="customstyles" />
			<link rel="stylesheet" type="text/css" href="{$redCMS->path}src/redcms-base/assets/default-skin.css" />
		{/block}
		
	</head>
	
{$rootAdmin = [
		['widget' => 'OpenPanelAction', 'label' => '[root]Edit block', 'href' => ParamManager::getLink('210'), 'action' => 'editCurrent'], 
		['widget' => 'OpenPanelAction', 'label' => '[root]Edit rights', 'href' => ParamManager::getLink('109'), 'action' => 'editCurrent'], 
		['widget' => 'OpenPanelAction', 'label' => '[root]Add sibling', 'href' => ParamManager::getLink('210'), 'action' => 'addSibling'],
		['widget' => 'OpenPanelAction', 'label' => '[root]Add child', 'href' => ParamManager::getLink('210'), 'action' => 'addChild'], 
		['widget' => 'DeleteBlockAction', 'label' => '[root]Delete', 'href' => ParamManager::getLink('103'), 'action' => 'editCurrent' ]]}
	
<body class="yui3-skin-sam yui-skin-sam" redadmin="{if $redCMS->sessionManager->currentUser->isAMember(1)}{htmlspecialchars(json_encode($rootAdmin))}{/if}"> 
	
	{block name='header'}
	<div class="redcms-hd">
		<h1>RedCMS-v0.2</h1>
	</div>
	{/block}

	<div class="yui3-g redcms-layout">
		<div class="yui3-u redcms-left">
			<div class="redcms-content">
				{foreach $this->getSiteBlocks() as $b}
					{if $b->canRead()}
						{$b->render()}
					{/if}
				{/foreach}
			</div>
		</div>
		<div class="yui3-u redcms-bd">
			{block name='bd-header'}{/block}
			
			{* DISPLAY HIERARCHY *}
			{block name='currentPagePath'}
				<div class="redcms-bd-title">
					<div class="redcms-bd-title-content">
						<div class="redcms-bd-title-item">Page d'accueil</div>
						<div class="redcms-bd-title-separator"></div>
						<div class="redcms-bd-title-item">Page d'accueil</div>
						<div class="redcms-clear"></div>
					</div>
					<div class="redcms-bd-title-right"></div>
						<div class="redcms-clear"></div>
				</div>
			{/block}
			
{/if}

			<div class="redcms-content" redid="{$this->id}" widget="Block" redadmin="{$this->renderAdminJSON()}" >
				{$this->longtext1}
				<div class="redcms-clear"></div>
				{foreach $this->getChildBlocks() as $b}
					{if $b->canRead()}
						{$b->render()}
					{/if}
				{/foreach}
			</div>
		
{if !$reload}
			{block name='bd-footer'}{/block}
		</div>
	</div>


	<div id="ft">
		{foreach $this->getFooterBlocks() as $b}
			{if $b->canRead()}
				{$b->render()}
			{/if}
		{/foreach}
	</div>

	{* YUI Seed *}
	<script type="text/javascript" src="http://yui.yahooapis.com/combo?3.3.0pr3/build/yui/yui-min.js&3.3.0pr3/build/loader/loader-min.js"></script>
	<script type="text/javascript" src="{$redCMS->path}src/redcms-base/js/redcms-bootstrap.js"></script>
	
	<script type="text/javascript" > 
	var Config = {
		path : "{$redCMS->path}",
		loggedIn : {json_encode($redCMS->sessionManager->isLoggedIn())},
		lang : '{$redCMS->lang}',
		debug : {json_encode($redCMS->config['debugMode'])},
	};
	Y.namespace('RedCMS').Config = Config;
	</script>
</body></html>
{/if}


