{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div {$this->renderBlockAttributes()} widget="Block" >
	<div class="redcms-conversation">
	{function name=conversation level=0}
		{foreach $blocks as $block}
			{$user = UserManager::getUserById($block->owner)}
		
			<div class="redcms-conversation-fragment redcms-conversation-{get_class($block)|lower}" redid="{$block->id}" widget="{get_class($block)}">
				<div class="redcms-icon" ><span /></div>
				<div class="redcms-conversation-title">
					
					<img width="30" height="30"  src="http://www.gravatar.com/avatar/{md5(strtolower($user->email))}?s=30&d=mm" style="float: left;margin: 3px 2px 0 0;border:1px solid gray"/>
					
					<h2>par <a href="{ParamManager::getLink('User Profile', $user->id)}">{$user->getLabel()}</a>, 
					posté {Utils::date_formatduration($block->dateadded)} 
					</h2>
					<h1><a name="{$block->title|escape:url}">{$block->title}</a></h1>
				</div>
				<div class="redcms-conversation-content">
					{$block->description}
					<div class="redcms-clear" ></div>
				</div>	
				<div class="redcms-conversation-footer">
					{$params = ['parentId' => $block->id]}
					<span widget="OpenPanelAction" params="{htmlspecialchars(json_encode($params))}" data-cfg='{ "onSuccessEvent": "dirty" }'>
						<a href="{ParamManager::getLink('290')}">Commenter</a>
					</span>
				</div>	
				{call conversation blocks=$block->getChildBlocks('dateadded') level=$level+1}
			</div>
		{/foreach}
	{/function}
	
	{$childBlocks=$this->getChildBlocks('dateadded DESC')}
	{if sizeof($childBlocks)>0} 
		{call conversation blocks=$childBlocks}
	{else}
		<div class="redcms-conversation-fragment">
			<center><em>There are no elements available.</em></center>
		</div>
	{/if}
	</div>
</div>