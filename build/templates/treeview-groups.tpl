{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<div class="redcms-block redcms-hidden" redid="{$this->id}" redadmin="{$this->renderAdminJSON()}" 
	widget="TreeView" requires="redcms-treeview" >
	<ul>
		{foreach $this->getChildBlocks() as $group}
			<li redid="{$group->id}" widget="Group">	
				<a href="#">
					{if $group->title}{$group->title}:{/if}
					{$group->name}
				</a>
			</li>
		{/foreach}
	</ul>
</div>