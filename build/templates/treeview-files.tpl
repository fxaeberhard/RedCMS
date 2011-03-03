{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<div class="redcms-block redcms-hidden" redid="{$this->id}" redadmin="{$this->renderAdminJSON()}" 
	widget="TreeView" requires="redcms-treeview" >

	{function name=menu level=0}
		<ul>
			{foreach $blocks as $block}
				<li redid="{$block->id}" widget="{get_class($block)}" >
					{$link = $block->getLink()}
					<a href="{$link}" target="_blank">{$block->getLabel()}</a>
					
					<div class="redcms-tooltip-content">
					
						{$relPath = str_replace($redCMS->path, '', $link)}
						{if file_exists($relPath)}
							{$ext = Utils::file_extension($link)}
							{if $ext == 'jpg' OR $ext == 'jpeg' OR $ext == 'png' OR $ext == 'gif'}
								<img src="{$link}" /><br />
							{/if}
							{round( filesize( $relPath )/ (1024), 2)}KB
						{else}
							Target file is missing
						{/if}
					</div>
				
					{$subBlocks = $block->getChildBlocks()}
					{if !empty($subBlocks)}
    					{call menu blocks=$subBlocks level=$level+1}
					{/if}
				</li>
			{/foreach}
		</ul>
	{/function}
	
	{$childs = $this->getChildBlocks()}
	{if sizeof($childs) == 0}
		<center><em>There are no files in this library.</em></center>
	{else}
		{call menu blocks=$childs}
	{/if}
</div>