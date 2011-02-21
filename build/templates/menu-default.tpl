{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*}
{$admin = $this->getLinkedBlock('admin')}
{$admin = (isset($admin))?$admin->getMenuItems():array()}
<div class="redcms-block" redid="{$this->id}" redadmin="{htmlspecialchars(json_encode($admin))}" widget="MenuNav" requires="redcms-menunav" >
	
	<div class="yui3-menu {block name=firstLevelClass}{/block}">
		<div class="yui3-menu-content">
			{function name=menu level=0}
				<ul class="first-of-type">
					{foreach $blocks as $block}
						
						<li class="yui3-menuitem" redid="{$block->id}" widget="{get_class($block)}">
						
							{$subBlocks = $block->getChildBlocks()}
							{$class=(!empty($subBlocks))?'yui3-menu-label':'yui3-menuitem-content'}
							{$targetPage = $block->getLinkedBlock("target")}
								
							{*{if isset($targetPage)}
							{$targetLink = $redCMS->paramManager->getLink($targetPage->fields['link'])}
							{else}
							{$targetLink = "#"}
							{/if}*} 
							<a class="{$class}" href="{$block->getLink()|default:'#'}">{$block->getLabel()|default:$targetPage->getLabel()}</a>
						
							{if !empty($subBlocks)}
								<div class="yui3-menu">
									<div class="yui3-menu-content">
		    							{call menu blocks=$subBlocks level=$level+1}
		    					</div></div>
							{/if}
						</li>
					{/foreach}
				</ul>
			{/function}
			{call menu blocks=$this->getChildBlocks()}
		</div>
	</div>
</div>