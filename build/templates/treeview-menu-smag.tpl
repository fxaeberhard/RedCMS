{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<style type="text/css">
<!--

.yui3-treeview-menu-smag .yui3-treeleaf-content.yui3-redcms-canread {
	text-decoration: underline;
}
.yui3-treeview-menu-smag .yui3-redcms-readonly {
	color:black;
}
.yui3-treeview-menu-smag .yui3-redcms-readonly:hover {
	color:black;
}
-->
</style>

<div class="redcms-block yui3-redcms-loading yui3-treeview-menu-smag" {$this->renderBlockAttributes()}
	widget="TreeView" requires="redcms-treeview">
	<strong style="font-size: 16px;">Menu membres</strong>(accès avec mot de passe)<br />
	{function name=treeSmag level=0}
		<ul>
			{foreach $blocks as $block}
				{$link = $block->getLink()}
				{if $link!= '#' OR  get_class($block) == 'Action'}
					{$class = ''}
					{if $block->canRead()}
						{$class = 'yui3-redcms-canread'}
					{else}
						{$class = 'yui3-redcms-readonly'}
						{$link='#'}
					{/if}
					<li redid="{$block->id}" widget="{get_class($block)}">
						<a class="{$class}" href="{$link}" >
							{$block->getLabel()}
						</a>
						
						{if get_class($block) == 'Action'}
							{$subBlocks = $block->getChildBlocks('number1')}
							{if !empty($subBlocks)}
		    					{call treeSmag blocks=$subBlocks level=$level+1}
							{/if}
						{/if}
					</li>
				{/if}
			{/foreach}
		</ul>
	{/function}
	
	{$childs = $this->getChildBlocks('number1')}
	{if sizeof($childs) == 0}
		<center><em>There are no pages in this menu.</em></center>
	{else}
		{call treeSmag blocks=$childs}
	{/if}
</div>