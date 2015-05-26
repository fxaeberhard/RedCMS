{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div {$this->renderBlockAttributes()} widget="Block"  data-noover=true  >
  
	
	{if $this->canWrite()}
		{$params = ['parentId' => $this->id]}
		<span class="yui3-redcms-button" widget="OpenPanelAction" requires="redcms-panel" 
			params="{htmlspecialchars(json_encode($params))}" data-cfg='{ "onSuccessEvent": "dirty" }'>
			<span>
				<a class="yui3-redcms-button-add" href="{ParamManager::getLink('310')}" >
					Nouveau
				</a>
			</span>
		</span>
		<br /> <br />
	{/if}
  
	<div class="redcms-conversation">
		{function name=conversation level=0}
			{foreach $blocks as $block}
				{$user = UserManager::getUserById($block->owner)}

				<div class="redcms-conversation-fragment redcms-conversation-{get_class($block)|lower}" redid="{$block->id}" widget="{get_class($block)}">

					<div class="redcms-icon"><span /></div>

					<div class="redcms-conversation-title">
						<img width="40" height="40" src="http://www.gravatar.com/avatar/{md5(strtolower($user->email))}?s=40&d=mm"/>
						<h1><a name="{$block->title|escape:url}">{$block->title}</a></h1>
						<h2>par <a href="{ParamManager::getLink('User Profile', $user->id)}">{$user->getLabel()}</a>, 
						posté {Utils::date_formatduration($block->dateadded)} 
						</h2>
					</div>
					
					<div class="redcms-conversation-content">
						{$block->description}
					</div>	
					<div class="redcms-clear" ></div>

					{call conversation blocks=$block->getChildBlocks('dateadded') level=$level+1}

					<div class="redcms-conversation-footer">
						{$params = ['parentId' => $block->id]}
						<span widget="OpenPanelAction" params="{htmlspecialchars(json_encode($params))}" data-cfg='{ "onSuccessEvent": "dirty" }'>
							<a href="{ParamManager::getLink('290')}">Commenter</a>
						</span>
					</div>
				</div>
			{/foreach}
		{/function}

		{$childBlocks=$this->getChildBlocks('dateadded DESC')}
		{if sizeof($childBlocks)>0} 
			{call conversation blocks=$childBlocks}
		{else}
			<div class="redcms-conversation-fragment">
				<center><em>Empty</em></center>
			</div>
		{/if}
	</div>
</div>