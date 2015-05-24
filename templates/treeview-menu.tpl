{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<div class="redcms-block yui3-redcms-loading yui3-treeview-menu yui3-redcms-treeview-content" {$this->renderBlockAttributes()}
     widget="TreeView" requires="redcms-treeview" data-noover=true>
  
  
	<style type="text/css">
	  .yui3-treeview-menu .yui3-treenode-leaf > a {
		  text-decoration: underline;
	  }
	  .yui3-treeview-menu .yui3-treenode-leaf > a:hover {
		  color: #487bba;
	  }
	</style>
	<div>
		{function name=tree level=0}{*{strip}*}
			[
			{foreach $blocks as $block}

				{$link = $block->getLink()}
				{if $block->canRead() AND ($link!= '#' OR  get_class($block) == 'Action')}

					{$icon = "html"}
					{if get_class($block) == 'Action'}
						{$icon = "folder"}
					{/if}

					  {
						"icon": "{$icon}",
						"label": "{urlencode("<i class='yui3-redcms-icon yui3-redcms-icon-$icon'></i>")}{$block->getLabel()}",
						"attrs": {
							"redid": {$block->id}, 
							"widget": "{get_class($block)}",
							"href": "{$link}",
							"data-noover":true
						}

					{if get_class($block) == 'Action'}
						{$subBlocks = $block->getChildBlocks('number1')}
						{if !empty($subBlocks)}
							,"children": {call tree blocks=$subBlocks level=$level+1}
						{/if}
					{/if}
					},
				{/if}
			{/foreach}
			{}]
		{*{/strip}*}{/function}

		{call tree blocks=$this->getChildBlocks('number1')}
	  </div>

</div>

