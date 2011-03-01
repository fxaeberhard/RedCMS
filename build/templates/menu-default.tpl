{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<div class="redcms-block" redid="{$this->id}" 
	redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" widget="MenuNav" requires="redcms-menunav" >
	
	<div class="yui3-menu {block name=firstLevelClass}{/block}">
		<div class="yui3-menu-content">
			{function name=menu level=0}
				<ul class="first-of-type">
					{foreach $blocks as $block}
						
						{if get_class($block) == 'Action'}
							{$subBlocks = $block->getChildBlocks()}
						{else}
							{$subBlocks = []}
						{/if}
						
						{$liClass=(empty($subBlocks))?'class="yui3-menuitem"':''}
						{$aClass=(empty($subBlocks))?'yui3-menuitem-content':'yui3-menu-label'}
						<li {$liClass} redid="{$block->id}" widget="{get_class($block)}">
							<a class="{$aClass}" href="{$block->getLink()|default:'#'}">{$block->getLabel()|default:'No label provided'}</a>
							
							{if !empty($subBlocks)}
								<div class="yui3-menu">
									<div class="yui3-menu-content">
		    							{call menu blocks=$subBlocks level=$level+1}
		    						</div>
		    					</div>
							{/if}
						</li>
					{/foreach}
				</ul>
			{/function}
			{call menu blocks=$this->getChildBlocks()}
		</div>
		{block name="footer"}{/block}
	</div>
</div>