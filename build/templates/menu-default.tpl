{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*}

<div class="red-block" redid="{$this->id}" widget="NavMenu" requires="redcms-navmenu">
	{function name=menu level=0}
		<div class="yui3-menu">
			<div class="yui3-menu-content">
				<ul class="first-of-type">
					{foreach $blocks as $block}
						
						<li class="yui3-menuitem">
							{if $block instanceof PageLinkAction}
								{$targetPage = $block->getLinkedBlock("target")}
								<a class="yui3-menuitem-content" href="{$redCMS->paramManager->getLink($targetPage->fields['link'])}">{$targetPage->fields['link']}</a>
							{else}
								<a class="yui3-menuitem-content" href="#" widget="{get_class($block)}">{$block->getLabel()}</a>
							{/if}
						</li>
						
						{$subBlocks = $block->getChildBlocks()}
						{if !empty($subBlocks)}
	    					{call menu blocks=$subBlocks level=$level+1}
						{/if}
						
					{/foreach}
				</ul>
			</div>
		</div>
	{/function}
	
	{call menu blocks=$this->getChildBlocks()}
</div>