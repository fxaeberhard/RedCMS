{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<div class="redcms-block yui3-redcms-loading" {$this->renderBlockAttributes()}
	widget="TreeView" requires="redcms-treeview" >
	
	{function name=menu level=0}
		<ul>
			{foreach $blocks as $block}
				{$link = $block->getLink()}
				{$ext = Utils::file_extension($link)}
				{if !isset($smarty.request.filter) || get_class($block) EQ 'Action' || strpos($smarty.request.filter, $ext) !== false}
					<li redid="{$block->id}" widget="{get_class($block)}" >
						<a href="{$link}" class="yui3-redcms-icon-{$ext}" target="_blank">{$block->getLabel()}</a>
						
						<div class="redcms-tooltip-content">
							{$relPath = substr( $link, strlen($redCMS->path))}
							{if file_exists($relPath)}
								{if $ext == 'jpg' OR $ext == 'jpeg' OR $ext == 'png' OR $ext == 'gif'}
									<img src="{$link}" /><br />
								{/if}
								{round( filesize( $relPath )/ (1024), 2)}KB
							{else}
								Target file is missing
							{/if}
						</div>
					
						{$subBlocks = $block->getChildBlocks('text1')}
						{if !empty($subBlocks)}
	    					{call menu blocks=$subBlocks level=$level+1}
						{/if}
					</li>
				{/if}
			{/foreach}
		</ul>
	{/function}
	
	{$childs = $this->getChildBlocks('text1')}
	{if sizeof($childs) == 0}
		<center><em>There are no files in this library.</em></center>
	{else}
		{call menu blocks=$childs}
	{/if}
</div>