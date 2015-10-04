{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div {*{$this->renderBlockAttributes()} widget="Block"*} >

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
				<div class="yui3-redcms-conversation-reader-item yui3-g redcms-conversation-{get_class($block)|lower}"
					onclick="window.location='{$page->getLink()}'"
					{*redid="{$block->id}" widget="{get_class($block)}"*} >
					
					<div class="redcms-icon yui3-u"><span></span></div>
					<div class="yui3-u" style="width:100%;margin-top:3px;text-align:left;">
						<img width="50" height="50" src="http://www.gravatar.com/avatar/{md5(strtolower($user->email))}?s=50&d=mm" style="float: left;margin: -2px 6px 1px 0;"/>
			
						<a style="font-weight: bold;display: inline-block;padding-top: 1px;line-height:13px;max-width:380px;" class="truncate">{$block->getLabel()}</a>
						
						<div class="redcms-small">
							{if $block instanceof EventField}{Utils::date_formatduration($block->date1)}, {/if}
							posté par <a href="{ParamManager::getLink('User Profile', $user->id)}">{$user->getLabel()}</a>
							{*{if $block instanceof EventField} a posté un événement
							{elseif $block instanceof ReplyField} a posté un commentaire
							{elseif $block instanceof NewsField} a posté une news
							{else} a posté un message{/if}*}
							sur la page 
							<a href="{$page->getLink()}">{$page->getLabel()}</a>
							{Utils::date_formatduration($block->dateadded)}
						</div>
					</div>
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
		  <center><em><br /><br />Empty<br /><br /></em></center>
		</div>
	{/if}
	</div>
	
</div>