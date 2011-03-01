{if !$reload}<div id="hd">
	<h1>RedCMS-v0.2</h1>
</div>
<div class="yui3-g" id="redcms-layout">
	<div class="yui3-u" id="redcms-left">
		<div class="content">
			{$siteBlocks[0]->render()}
		</div>
	</div>
	<div class="yui3-u" id="redcms-bd">{/if}
		<div class="content" redid="{$this->id}" widget="Block" 
		redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" >
			{$this->longtext1}
			
			{foreach $this->getChildBlocks() as $b}
				{$b->render()}
			{/foreach}
		</div>
	{if !$reload}</div>
</div>{/if}


