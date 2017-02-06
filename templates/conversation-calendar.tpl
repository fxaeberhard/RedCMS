{*
* Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
* Code licensed under the BSD License:
* http://redcms.red-agent.com/license.html
*}

<div {$this->renderBlockAttributes()} widget="Block"  data-noover=true >

	{$params = ['parentId' => $this->id]}
	{if $this->canWrite()}
		<span class="yui3-redcms-button" widget="OpenPanelAction" requires="redcms-panel" 
			  params="{htmlspecialchars(json_encode($params))}" data-cfg='{ "onSuccessEvent": "dirty" }'>
			<span>
				<a class="yui3-redcms-button-add" href="{ParamManager::getLink('280')}" >Nouveau</a>
			</span>
		</span>
	{/if}

	{if !isset($smarty.get.past)}
		<a style="float:right;margin:15px 0;" href="{$this->getPageLink()}?past=true">Archives</a>
		{$childBlocks=$this->getChildBlocksS("date1 > NOW() ORDER BY date1")}
	{else}
		<a style="float:right;margin:15px 0;" href="{$this->getPageLink()}">Current dates</a>
		{$childBlocks=$this->getChildBlocksS('date1 < NOW() ORDER BY date1')}
	{/if}
	<div class="redcms-clear"></div>

	<div class="redcms-conversation">
		{function name=conversation level=0}
			{foreach $blocks as $block}
				{$user = UserManager::getUserById($block->owner)}

				<div class="redcms-conversation-fragment redcms-conversation-{get_class($block)|lower}" redid="{$block->id}" widget="{get_class($block)}">
				  
				   <div class="redcms-icon" ><span /></div>
				  
				  <div class="redcms-conversation-title">
					
					{if $block instanceof EventField}
						<h1><a name="{$block->title|escape:url}" href="{$block->text3|default:'#'}" target="_blank">{$block->title}</a></h1>
						<h2>
							{if $block->text2}{$block->text2}, {/if}
							{*{Utils::date('\l\e j F Y', $block->date1)}*}
							{Utils::date_formatinterval($block->date1, $block->date2)}{if $block->text3}, <a href="{$block->text3}" target="_blank">website</a>{/if}
						</h2>
					{else}		
						<img class="avatar" src="http://www.gravatar.com/avatar/{md5(strtolower($user->email))}?s=40&d=mm" width="40" height="40" />
						<h1><a name="{$block->title|escape:url}">{$block->title}</a></h1>
						<h2>par <a href="{ParamManager::getLink('User Profile', $user->id)}">{$user->getLabel()}</a>, posté {Utils::date_formatduration($block->dateadded)}</h2>						
					{/if}

					</div>
					<div class="redcms-conversation-content">{$block->longtext1}</div>
					<div class="redcms-clear"></div>

					{call conversation blocks=$block->getChildBlocks('dateadded') level=$level+1}

					{if $this->canWrite()}
						<div class="redcms-conversation-footer">
							{$params = ['parentId' => $block->id]}
							<span widget="OpenPanelAction" params="{htmlspecialchars(json_encode($params))}" data-cfg='{ "onSuccessEvent": "dirty" }'>
								<a href="{ParamManager::getLink('290')}">Commenter</a>
							</span>
						</div>	
					{/if}
				</div>
			{/foreach}
		{/function}

		{if sizeof($childBlocks)>0} 
			{call conversation blocks=$childBlocks}
		{else}
			<div class="redcms-conversation-fragment">
				<center><em>Empty</em></center>
			</div>
		{/if}
	</div>
</div>
	