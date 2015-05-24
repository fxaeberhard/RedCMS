{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div class="redcms-block" {$this->renderBlockAttributes()} widget="Accordion" requires="redcms-accordion" >
	
	<button class='yui3-button' widget='OpenPanelAction' params='{ "parentId":9 }' href="/RedCMS/150/" data-cfg='{ "onSuccessEvent": "dirty" }'><i class='fa fa-plus-square'></i> Create user</button>
	<br /><br />
	
	<div class="yui3-g yui3-redcms-accordion-bd">
		<div class="yui3-u-1-3">Name</div>
		<div class="yui3-u-1-3">Email</div>
		<div class="yui3-u-1-3">Status</div>
	</div>
	
	<ul>
		{foreach $this->getChildBlocks() as $block}
			<li redid="{$block->id}" widget="User"> 
				<div class="yui3-redcms-accordion-title">
					<div class="yui3-g">
						<div class="yui3-u-1-3">
						<span class="redcms-icon-user"></span>
							{$block->name} {$block->surname}
						</div>
						<div class="yui3-u-1-3">{$block->email}</div>
						<div class="yui3-u-1-3">{if $block->isAMember('1')}Root{else}
						{if $block->isAMember('2')}Administrator{/if}{/if}</div>
					</div>
				</div> 
				<div class="yui3-redcms-accordion-item">
					<div class="yui3-redcms-accordion-item-content">
						{include file="user-default.tpl" inline}
					</div>
				</div> 
			</li> 
		{/foreach}
	</ul>
 </div>