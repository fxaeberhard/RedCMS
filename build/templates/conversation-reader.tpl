{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div redid="{$this->id}" redadmin="{$this->renderAdminJSON()}" widget="Block" >

	<style type="text/css">		
		.yui3-redcms-conversation-reader-item {
			background-color: white;
			border-top: 1px solid gray;
			cursor:pointer;
			padding: 2px;
		}
		.yui3-redcms-conversation-reader-item:hover {
			background-color: #D1D8DF;
		}
		.yui3-redcms-conversation-reader-item > div {
			display:inline-block;
		}
	</style>
	
	<div class="redcms-conversation yui3-redcms-conversation-reader">
	
		{* Headers *}
		<div class="yui3-redcms-conversation-reader-hd">
			Activité récente sur le site
		</div>
	
	
	{function name=conversation level=0}
		{$counter = 0}
		{foreach $blocks as $block}
			{if $counter<10 AND $block->canRead()}
				{$user = $block->getOwner()}
				{$page = $block->ancestor(PageBlock)}
				<div class="yui3-redcms-conversation-reader-item redcms-conversation-{get_class($block)|lower}"
					onclick="window.location='{$page->getLink()}'"
					redid="{$block->id}" widget="{get_class($block)}">
					
					<div class="redcms-icon"><span></span></div>
					<div class="redcms-clear"></div>
					<div>
						<img src="http://www.gravatar.com/avatar/{md5(strtolower($user->email))}?s=40&d=mm" style="float: left;margin: 3px 3px 0 0;border:1px solid gray"/>
			
						<a href="{ParamManager::getLink('User Profile', $user->id)}">{$user->getLabel()}</a>
						{if $block instanceof EventField} a posté un événement
						{elseif $block instanceof ReplyField} a posté un commentaire
						{elseif $block instanceof NewsField} a posté une news
						{else} a posté un message{/if}
						sur la page 
						<a href="{$page->getLink()}">{$page->getLabel()}</a>
						<br />
						<a style="font-weight: bold">{$block->getLabel()}</a>
						<div class="redcms-small">
							{Utils::date_formatduration($block->dateadded)}
						</div>
					<div class="redcms-clear"></div>
					</div>
					<div class="redcms-clear"></div>
				</div>
				{$counter = $counter+1}
			{/if}
		{/foreach}
	{/function}
	
	{$childBlocks=$this->getChildBlocks("dateadded DESC")}
	{if sizeof($childBlocks)>0} 
		{call conversation blocks=$childBlocks}
	{else}
		<div class="yui3-redcms-conversation-reader-item">
			<center><em>No recent activity</em></center>
		</div>
	{/if}
	</div>
	
</div>