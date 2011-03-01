{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<div class="redcms-conversation" redid="{$this->id}" redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" widget="Block" requires="" >
	{function name=conversation level=0}
		{foreach $blocks as $block}
			{$user = UserManager::getUserById($block->owner)}
		
			<div class="redcms-conversation-fragment redcms-conversation-{get_class($block)|lower}" redid="{$block->id}" widget="{get_class($block)}">
				<div class="redcms-icon" ><span /></div>
				<div class="redcms-conversation-title">
					<h2>par <span class="redcms-user" userid="{$user->id}">{$user->getLabel()}</span>,
						posté 
					</h2>
					<h1><a name="{$block->title|escape:url}">{$block->title}</a></h1>
				</div>
				<div class="redcms-conversation-content">
					{$block->description}
				</div>	
					
				{call conversation blocks=$block->getChildBlocks() level=$level+1}
			</div>
		{/foreach}
	{/function}
	
	{$childBlocks=$this->getChildBlocks()}
	{if sizeof($childBlocks)>0} 
		{call conversation blocks=$childBlocks}
	{else}
		<center><em>There are no elements available.</em></center>
	{/if}
</div>