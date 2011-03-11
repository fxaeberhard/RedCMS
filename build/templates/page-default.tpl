{* 
 *
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 * {$this->renderBlockAttributes()}z
 *}{if !$reload}<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
{* HTML5 <!DOCTYPE html>*}
{* HTML4 Transnational <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">*}
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset={$redCMS->config['charset']}" />
		<meta http-equiv="Content-Language" content="{$redCMS->lang}" />
		<title>{$this->getLabel()}{$redCMS->config['windowTitleSuffix']}</title>
		<meta name="DESCRIPTION" content="" />
		<meta name="KEYWORDS" content="{$redCMS->config['keywordSuffix']}" />     
		<meta name="robots" content="index, follow" />
		<meta name="contact" content="{$redCMS->config['adminMail']}" />
		<meta name="Audience" content="General" />
		<meta name="Distribution" content="Global" />
		<meta name="revisit-after" content="30 days" />
		{*<meta name="expires" content="never" /> *}
		
		{block name="stylesheets"}
			<link rel="stylesheet" type="text/css" 
			href="http://yui.yahooapis.com/combo?3.3.0/build/cssfonts/fonts-min.css&3.3.0/build/cssreset/reset-min.css&3.3.0/build/cssgrids/grids-min.css&3.3.0/build/cssbase/base-min.css&3.3.0pr3/build/widget/assets/skins/sam/widget.css&3.3.0pr3/build/node-menunav/assets/skins/sam/node-menunav.css&" charset="utf-8" />
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
		RedCMS-v0.2
	</div>
	{/block}
	
	{flush()}
	
	<div class="yui3-g redcms-layout">
		{********** Render global blocks **********}
		<div class="yui3-u redcms-left">
			<div class="redcms-content">
				{foreach $this->getSiteBlocks() as $b}
					{if $b->canRead()}
						{$b->render()}
					{/if}
					{flush()}
				{/foreach}
			</div>
		</div>
		<div class="yui3-u redcms-bd">
			{block name='bd-header'}{/block}
			
			{********** Display Hierarchy **********}
			{block name='currentPagePath'}
				<div class="redcms-bd-title">
					<div class="redcms-bd-title-content">
						{foreach $redCMS->currentHierarchy as $b name='hierarchy'}
							<div class="redcms-bd-title-item">
								{$b->getLabel()}
							</div>
							{if NOT $smarty.foreach.hierarchy.last}
								<div class="redcms-bd-title-separator"></div>
							{/if}
						{/foreach}
						<div class="redcms-clear"></div>
					</div>
					<div class="redcms-bd-title-right"></div>
					<div class="redcms-clear"></div>
				</div>
			{/block}
			
{/if}
			{block name="bd"}
				<div class="redcms-bd-content" widget="Block" {$this->renderBlockAttributes()} >
				
					{********** Display block content **********}
					{$this->longtext1}
					<div class="redcms-clear"></div>
					
					{********** Render the childs in a vertical list **********}
					{foreach $this->getChildBlocks() as $b}
						{if $b->canRead()}
							<br />
							{$b->render()}
						{/if}
						{flush()}
					{/foreach}
				</div>
			{/block}
		
{if !$reload}
			{block name='bd-footer'}{/block}
		</div>
	</div>

	
	<div class="redcms-ft">
		<div class="redcms-ft-content">
			{block name='ft-content'}
				<hr />
				Powered by <a href="http://redcms.red-agent.com">RedCMS</a> | Version {$redCMS->config['version']} | &copy; 2011, Francois-Xavier Aeberhard
			{/block}
		</div>
		
		{********** Render footer's blocks **********}
		{foreach $this->getFooterBlocks() as $b}
			{if $b->canRead()}
				{$b->render()}
			{/if}
		{/foreach}
	</div>

	{********** YUI JS **********}
	<script type="text/javascript" src="http://yui.yahooapis.com/combo?3.3.0pr3/build/yui/yui-min.js&3.3.0pr3/build/loader/loader-min.js"></script>
	{*<script type="text/javascript" src="http://yui.yahooapis.com/combo?3.3.0pr3/build/yui/yui.js&3.3.0pr3/build/loader/loader.js"></script>*}
	
	{********** Pass config to JS Object **********}
	<script type="text/javascript" > 
		var Config = {
			path : "{$redCMS->path}",
			loggedIn : {json_encode($redCMS->sessionManager->isLoggedIn())},
			lang : '{$redCMS->lang}',
			debug : {json_encode($redCMS->config['debugMode'])},
		};
	</script>
	
	{* RedCMS JS *}
	{* <script type="text/javascript" src="{$redCMS->path}src/redcms-base/js/redcms-bootstrap.js"></script> *}
	<script type="text/javascript" src="{$redCMS->path}combo/?/build/redcms-base/redcms-base-min.js&/build/redcms-menu/redcms-menunav.js&/src/redcms-base/js/redcms-bootstrap.js"></script>
	

</body></html>
{/if}


