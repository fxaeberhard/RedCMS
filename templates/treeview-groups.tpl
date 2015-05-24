{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<div class="redcms-block yui3-redcms-loading yui3-redcms-treeview-content" {$this->renderBlockAttributes()}
     widget="TreeView" requires="redcms-treeview" data-noover=true >
	<button class='yui3-button' widget='OpenPanelAction' params='{ "parentId":12 }' href="/RedCMS/200/" data-cfg='{ "onSuccessEvent": "dirty" }'><i class='fa fa-plus-square'></i> New group</button>
	<br /><br />
	<div>
        [
		{foreach $this->getChildBlocks() as $group}
			{
				"label": "{if $group->title}{$group->title}: {/if}{$group->name}",
				"icon": "default",
				"attrs": {
					"redid": {$group->id}, 
					"widget": "Group"
				}
            },
		{/foreach} { }]
  </div>
</div>