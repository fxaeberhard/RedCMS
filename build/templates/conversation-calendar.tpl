{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div {$this->renderBlockAttributes()} widget="Block" >
	
	{$params = ['parentId' => $this->id]}
	<span class="yui3-redcms-button" widget="BlockReloadOpenPanelAction" requires="redcms-panel" 
		params="{htmlspecialchars(json_encode($params))}">
		<span>
			<a class="yui3-redcms-button-add" href="{ParamManager::getLink('280')}" >
				Poster un nouvel évènement
			</a>
		</span>
	</span>
	
	<style type="text/css">
		.calendar-layout {
			margin-left:100px;
		}
		.calendar-right {
			width:100%;
		}
		.calendar-left {
			width:100px;
			margin-left:-100px;
			font-style: italic;
		}
	</style>
	
	<div class="redcms-conversation">
	{function name=conversation level=0}
		{foreach $blocks as $block}
			{$user = UserManager::getUserById($block->owner)}
		
			<div class="redcms-conversation-fragment redcms-conversation-{get_class($block)|lower}" redid="{$block->id}" widget="{get_class($block)}">
				<div class="redcms-icon" ><span /></div>
				<div class="redcms-conversation-title">
					
					<img src="http://www.gravatar.com/avatar/{md5(strtolower($user->email))}?s=30&d=mm" width="30" height="30" style="float: left;margin: 3px 2px 0 0;border:1px solid gray"/>
					
					<h2>par <a href="{ParamManager::getLink('User Profile', $user->id)}">{$user->getLabel()}</a>, 
					posté {Utils::date_formatduration($block->dateadded)} 
					</h2>
					<h1><a name="{$block->title|escape:url}">{$block->title}</a></h1>
				</div>
				<div class="redcms-conversation-content">
					{if $block instanceof EventField}
					<div class="yui3-g calendar-layout">
						<div class="yui3-u calendar-left">Date:</div>
						<div class="yui3-u calendar-right">{Utils::date('\l\e j F Y', $block->date1)}</div>
					{*	<div class="yui3-u calendar-right">{Utils::date('\l\e j F Y à H:i', $block->date1)}</div>*}
					</div>
					<div class="yui3-g calendar-layout">
						<div class="yui3-u calendar-left">Lieu:</div>
						<div class="yui3-u calendar-right">{$block->text2}</div>
					</div>
					
					<div class="yui3-g calendar-layout">
						<div class="yui3-u calendar-left">Description:</div>
						<div class="yui3-u calendar-right">
							{$block->longtext1}
						</div>
					</div>
					{else}
						{$block->longtext1}
					{/if}
					
					<div class="redcms-clear" ></div>
				</div>	
				<div class="redcms-conversation-footer">
					{$params = ['parentId' => $block->id]}
					<span widget="BlockReloadOpenPanelAction" params="{htmlspecialchars(json_encode($params))}">
						<a href="{ParamManager::getLink('290')}">Commenter</a>
					</span>
				</div>	
				{call conversation blocks=$block->getChildBlocks('dateadded') level=$level+1}
			</div>
		{/foreach}
	{/function}
	
	{$childBlocks=$this->getChildBlocks('date1')}
	{if sizeof($childBlocks)>0} 
		{call conversation blocks=$childBlocks}
	{else}
		<div class="redcms-conversation-fragment">
			<center><em>There are no events in this calendar</em></center>
		</div>
	{/if}
	</div>
</div>