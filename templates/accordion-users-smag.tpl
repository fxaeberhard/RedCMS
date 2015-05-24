{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div class="redcms-block" {$this->renderBlockAttributes()} widget="Accordion" requires="redcms-accordion" >
	
	<div class="yui3-g yui3-redcms-accordion-bd">
		<div class="yui3-u-1-3">Nom</div>
		<div class="yui3-u-1-3">Etablissement</div>
		<div class="yui3-u-1-3">Statuts</div>
	</div>
	<ul>
		{foreach $this->getUsersByGroup() as $block}
{*		{if $block->isAMember(10) || $block->isAMember(11) || $block->isAMember(12)}*}
		{if $block->id NEQ 1}
			<li redid="{$block->id}" widget="User">	{*
				<a href="#" class="yui3-redcms-accordion-title">{$block->getLabel()}</a>*}
				<div class="yui3-redcms-accordion-title">
					<div class="yui3-g">
						<div class="yui3-u-1-3">
						<span class="redcms-icon-user"></span>
							{$block->name} {$block->surname}
						</div>
						<div class="yui3-u-1-3">{$block->text1}</div>
						<div class="yui3-u-1-3">{if $block->isAMember(10)}Membre du comité{elseif $block->isAMember(11)}Membre de la SMAG
						{elseif $block->isAMember(12)}Ancien membre{/if}</div>
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