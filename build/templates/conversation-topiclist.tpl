{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div redid="{$this->id}" redadmin="{$this->renderAdminJSON()}" widget="Block" >
	
	{$params = ['parentId' => $this->id]}
	<span class="yui3-redcms-button" widget="BlockReloadOpenPanelAction" requires="redcms-panel" 
		params="{htmlspecialchars(json_encode($params))}">
		<span>
			<a class="yui3-redcms-button-add" href="{ParamManager::getLink('300')}" >
				Poster un nouveau message
			</a>
		</span>
	</span>
	
	<style type="text/css">
		.topiclist-layout {
			margin-right:500px;
		}
		.topiclist-main {
			width:100%;
		}
		.topiclist-col1 {
			width:500px;
			margin-right:-500px;
		}
		.topiclist-layout .yui3-u {
			/*padding:5px;*/
		}
	</style>
	
	
	<div class="redcms-conversation">
	
		{* Headers *}
		<div class="redcms-conversation-fragment redcms-conversation-hd" style="font-weight: bolder;padding: 5px;margin-bottom: 2px;">
			<div class="yui3-g topiclist-layout">
				<div class="yui3-u topiclist-main">
					Message
				</div>
				<div class="yui3-u topiclist-col1">
					<div class="yui3-g" style="text-align:center">
						<div class="yui3-u-1-3">
							Auteur
						</div>
						<div class="yui3-u-1-3">
							Réponses
						</div>
						<div class="yui3-u-1-3">
							Dernière réponse
						</div>
					</div>
				</div>
			</div>
		</div>
	
	
	{function name=conversation level=0}
		{foreach $blocks as $block}
			{$user = UserManager::getUserById($block->owner)}
			{$replies = $block->getChildBlocks()}
			
			<div class="redcms-conversation-fragment redcms-conversation-{get_class($block)|lower}" style="padding: 5px;margin-bottom: 2px;"
				redid="{$block->id}" widget="{get_class($block)}">
				<div class="yui3-g topiclist-layout">
					<div class="yui3-u topiclist-main">
						<img width="40" height="40" src="http://www.gravatar.com/avatar/{md5(strtolower($user->email))}?s=40&d=mm" style="float: left;margin: 2px 3px 0 0;border:1px solid gray"/>
			
						<a href="{ParamManager::getLink($this->parentBlock()->link, $block->title)}">{$block->title}</a><br />
						<span style="font-size: 8pt;">
						posté {Utils::date_formatduration($block->dateadded)} <br />
						{$block->description|strip_tags|truncate}
						</span>
					</div>
					<div class="yui3-u topiclist-col1">
						<div class="yui3-g" style="text-align:center">
							<div class="yui3-u-1-3">
								<a href="{ParamManager::getLink('User Profile', $user->id)}">{$user->getLabel()}</a>
							</div>
							<div class="yui3-u-1-3">
								{sizeof($replies)}
							</div>
							<div class="yui3-u-1-3">
								{if !empty($replies)}
									{$replyAuthor = UserManager::getUserById($replies[0]->owner)}
									{$replies[0]->title}<br />
									<span style="font-size: 8pt;">
										par <a href="{ParamManager::getLink('User Profile', $replyAuthor->id)}">{$replyAuthor->getLabel()}</a>, 
										posté {Utils::date_formatduration($replies[0]->dateadded)}
									</span>
								{else}
									-
								{/if}
							</div>
						</div>
					</div>
				</div>
			</div>
			
		{/foreach}
	{/function}
	
	{$childBlocks=$this->getChildBlocks("dateadded")}
	{if sizeof($childBlocks)>0} 
		{call conversation blocks=$childBlocks}
	{else}
		<div class="redcms-conversation-fragment">
			<center><em>Il n'y a pas de messages dans ce forum.</em></center>
		</div>
	{/if}
	</div>
	
	{$params = ['parentId' => $this->id]}
	<span class="yui3-redcms-button" widget="BlockReloadOpenPanelAction" requires="redcms-panel" 
		params="{htmlspecialchars(json_encode($params))}">
		<span>
			<a class="yui3-redcms-button-add" href="{ParamManager::getLink('300')}" >
				Poster un nouveau message
			</a>
		</span>
	</span>
	
</div>