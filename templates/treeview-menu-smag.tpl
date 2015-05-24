{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<div class="redcms-block yui3-redcms-loading yui3-treeview-menu-smag yui3-redcms-treeview-content" {$this->renderBlockAttributes()}
     widget="TreeView" requires="redcms-treeview" data-noover=true>
  
	<style type="text/css">
	  .yui3-treeview-menu-smag .yui3-treenode-leaf > a {
		  text-decoration: underline;
	  }
	  .yui3-treeview-menu-smag .yui3-treenode-leaf > a[data-readonly="true"] {
		  color:black;
		  cursor: not-allowed;
		  text-decoration: none;
	  }
	  .yui3-treeview-menu-smag .yui3-treenode-leaf > a[data-readonly="true"]:hover {
		  color:black;
	  }
	</style>
	<br />
	<strong style="font-size: 16px;">Menu membres</strong> (accès avec mot de passe)<br />
	
	<div>
		{function name=treesmag level=0}{strip}
			  [
			  {foreach $blocks as $block}

					{$link = $block->getLink()}

					
					{if $link!= '#' OR get_class($block) == 'Action'}
						
						{$icon = "html"}
						{if get_class($block) == 'Action'}
							{$icon = "folder"}
						{/if}
						
						{if !$block->canRead()}
							{$link='#'}
						{/if}
						{
						"icon": "{$icon}",
						"label": "{$block->getLabel()}",
						"attrs": {
							"redid": {$block->id}, 
							"widget": "{get_class($block)}",
							{* "href": "{$link}",*}
							"data-noover":true,
							{* "data-readonly":{if $block->canRead()}false{else}true{/if}*}
							"data-readonly": true
						}

						{if get_class($block) == 'Action'}
							{$subBlocks = $block->getChildBlocks('number1')}
							{if !empty($subBlocks)}
								,"children": {call treesmag blocks=$subBlocks level=$level+1}
							{/if}
						{/if}
						},
					{/if}
			  {/foreach}
			  {}]
		{/strip}{/function}
		
		{call treesmag blocks=$this->getChildBlocks('number1')}

	</div>

</div>

