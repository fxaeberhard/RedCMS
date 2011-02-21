{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*}
{$admin = $this->getLinkedBlock('admin')}
{$admin = (isset($admin))?$admin->getMenuItems():array()}
<div class="redcms-block" redid="{$this->id}" redadmin="{htmlspecialchars(json_encode($admin))}" 
	widget="TreeView" requires="redcms-treeview" >

	{function name=menu level=0}
		<ul>
			{foreach $blocks as $block}
				<li redid="{$block->id}" {*widget="{get_class($block)}"*}>
				
					{$subBlocks = $block->getChildBlocks()}
					{if isset($block->fields['link'])}
						{$targetLink = $block->getLink()}
					{else}
						{$targetLink = '#'}
					{/if}
						
					<a href="{$targetLink}">{$block->getLabel()}</a>
				
					{if !empty($subBlocks)}
    					{call menu blocks=$subBlocks level=$level+1}
					{/if}
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