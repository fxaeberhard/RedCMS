{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}
 
<div class="redcms-block redcms-hidden" redid="{$this->id}" redadmin="{$this->renderAdminJSON()}" 
	widget="TreeView" requires="redcms-treeview" style="min-width: 600px">
	<ul>
		{foreach $this->getChildBlocks() as $block}
			<li redid="{$block->id}" widget="User">	
				<a href="#">{$block->getLabel()}</a>
				<ul>
					{include file="user-default.tpl" inline}
		        </ul> 
			</li>
		{/foreach}
	</ul>
</div>