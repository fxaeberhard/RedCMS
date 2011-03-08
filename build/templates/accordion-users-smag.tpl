{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div class="redcms-block" redid="{$this->id}" redadmin="{$this->renderAdminJSON()}" widget="Accordion" requires="redcms-accordion" >
	
	<div class="yui3-g yui3-redcms-accordion-bd">
		<div class="yui3-u-1-3">Nom</div>
		<div class="yui3-u-1-3">Etablissement</div>
		<div class="yui3-u-1-3">Statuts</div>
	</div>
	
	<ul>
		{foreach $this->getChildBlocks() as $block}
		{if $block->id NEQ 1}
			<li redid="{$block->id}" widget="User"> 
				<div class="yui3-redcms-accordion-title">
					<div class="yui3-g">
						<div class="yui3-u-1-3">
						<span class="redcms-icon-user"></span>
							{$block->name} {$block->surname}
						</div>
						<div class="yui3-u-1-3">{$block->text1}</div>
						<div class="yui3-u-1-3">{if $block->isAMember(10)}Membre du comité{else}
						{if $block->isAMember(11)}Membre de la SMAG{/if}{/if}</div>
					</div>
				</div> 
				<div class="yui3-redcms-accordion-item">
					<div class="yui3-redcms-accordion-item-content">
						{include file="user-default.tpl" inline}
					</div>
				</div> 
			</li> 
		{/if}
		{/foreach}
	</ul>
 </div>