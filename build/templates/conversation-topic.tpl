{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div {$this->renderBlockAttributes()} widget="Block" >
	
	{$childBlocks=$this->getChildBlocks()}
	{$params = ['parentId' => $childBlocks[0]->id]}
	<span class="yui3-redcms-button" widget="BlockReloadOpenPanelAction" requires="redcms-panel" 
		params="{htmlspecialchars(json_encode($params))}">
		<span>
			<a class="yui3-redcms-button-add" href="{ParamManager::getLink('290')}" >
				Répondre
			</a>
		</span>
	</span>
	
	<div class="redcms-conversation">
	{function name=conversation level=0}
		{foreach $blocks as $block}
			{$user = UserManager::getUserById($block->owner)}
		
			<div class="redcms-conversation-fragment redcms-conversation-{get_class($block)|lower}" redid="{$block->id}" widget="{get_class($block)}">
				<div class="redcms-icon" ><span /></div>
				<div class="redcms-conversation-title">
				
					<img width="30" height="30" src="http://www.gravatar.com/avatar/{md5(strtolower($user->email))}?s=30&d=mm" style="float: left;margin: 3px 2px 0 0;border:1px solid gray"/>
					<h2>par <a href="{ParamManager::getLink('User Profile', $user->id)}">{$user->getLabel()}</a>, 
					posté {Utils::date_formatduration($block->dateadded)} 
					</h2>
					<h1><a name="{$block->title|escape:url}">{$block->title}</a></h1>
				</div>
				<div class="redcms-conversation-content">
					<div>
						{$block->description}
					</div>
					<div class="redcms-clear" ></div>
				</div>	
				<div class="redcms-conversation-footer">
					{$params = ['parentId' => $block->id]}
					<span widget="BlockReloadOpenPanelAction" params="{htmlspecialchars(json_encode($params))}">
						<a href="{ParamManager::getLink('290')}">Répondre</a>
					</span>
				</div>	
				{call conversation blocks=$block->getChildBlocks("dateadded") level=$level+1}
			</div>
		{/foreach}
	{/function}
	
	{if sizeof($childBlocks)>0} 
		{call conversation blocks=$childBlocks}
	{else}
		<center><em>There are no elements available.</em></center>
	{/if}
	</div>
</div>