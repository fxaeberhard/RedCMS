{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<div class="redcms-block yui3-redcms-loading yui3-redcms-treeview-content" {$this->renderBlockAttributes()}
     widget="TreeView" requires="redcms-treeview" data-noover=true >
  <button class='yui3-button' widget='OpenPanelAction' params='{ "parentId":2 }' href="{$redCMS->path}130/" data-cfg='{ "onSuccessEvent": "dirty" }'><i class='fa fa-plus-square'></i> New page</button>
  <br /><br />
  <div>
    {function name=menu level=0}
        [
        {foreach $blocks as $block}
            {
            "label": "{$block->getLabel()}",
			"icon": "html",
            "attrs": {
				"redid": {$block->id}, 
				"widget": "{get_class($block)}",
				"href": "{$block->getLink()}"
            }

            {*  {$subBlocks = $block->getChildBlocks('link')}
            {if !empty($subBlocks)}
            ,children: {call menu blocks=$subBlocks level=$level+1}
            {/if}*}
            }
			{if !$smarty.section.menu.last},{/if}

        {/foreach}
        {}]
    {/function}

	{*{call menu blocks=$this->getChildBlocks('link')}*}
    {call menu blocks=$this->getPages('link')}

  </div>
</div>