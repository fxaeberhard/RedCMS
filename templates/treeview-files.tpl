{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<div {$this->renderBlockAttributes()} class="redcms-block yui3-redcms-loading yui3-redcms-treeview-content" 
                                      widget="TreeView" requires="redcms-treeview" data-noover=true >
	{block name="buttons"}
	<button class='yui3-button' widget='OpenPanelAction' params='{ "parentId":6 }' href="/RedCMS/170/" data-cfg='{ "onSuccessEvent": "dirty" }'><i class='fa fa-upload'></i> Upload file</button>
	{/block}
	<br /><br />
	
	<div>
		{function name=menu level=0}
			[
			{foreach $blocks as $block}
				{$link = $block->getLink()}
				{$ext = Utils::file_extension($link)}
				{if !isset($smarty.request.filter) || get_class($block) EQ 'Action' || strpos($smarty.request.filter, $ext) !== false}
					{
						"label": "{$block->getLabel()}",						
						"icon": "{$ext}",
						"attrs": {
							"redid": {$block->id}, 
							"widget": "{get_class($block)}",
							"href": "{$link}",
							{$relPath = substr( $link, strlen($redCMS->path))}
							"title": {strip}{if file_exists($relPath)}
							"{if $ext == 'jpg' OR $ext == 'jpeg' OR $ext == 'png' OR $ext == 'gif'}{urlencode("<")}img src='{$link}' {urlencode("/><br/>")}{/if}{round( filesize( $relPath )/ (1024), 2)}KB"
							{else}
								"Target file is missing"
							{/if}{/strip}
						}

						{$subBlocks = $block->getChildBlocks('text1')}
						{if !empty($subBlocks)}
							,children: {call menu blocks=$subBlocks level=$level+1}
						{/if}
					},	
				{/if}
			{/foreach}
			{}]
		{/function}

	{capture assign='orderby'}{block "orderby"}text1{/block}{/capture}
	{$childs = $this->getChildBlocks($orderby)}
	{call menu blocks=$childs}

	</div>
</div>