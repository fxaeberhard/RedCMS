{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<div class="redcms-block" redid="{$this->id}" redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" 
	widget="TreeView" requires="redcms-treeview" >

	{function name=menu level=0}
		<ul>
			{foreach $blocks as $block}
				<li redid="{$block->id}" widget="{get_class($block)}">
					<a href="{$block->getLink()|default:'#'}">{$block->getLabel()}</a>
					{*
					{$subBlocks = $block->getChildBlocks()}
					{if !empty($subBlocks)}
    					{call menu blocks=$subBlocks level=$level+1}
					{/if}*}
				</li>
			{/foreach}
		</ul>
	{/function}
	
	{$childs = $this->getChildBlocks()}
	{if sizeof($childs) == 0}
		<center><em>There is no items in this block.</em></center>
	{else}
		{call menu blocks=$childs}
	{/if}
</div>