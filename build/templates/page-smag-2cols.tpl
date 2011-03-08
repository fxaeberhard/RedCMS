{extends file="page-smag.tpl"}

{block name="bd"}

	<div class="redcms-content" widget="Block" {$this->renderBlockAttributes()} >
		<div class="yui3-g">
			<div class="yui3-u-1-2">
				{$this->longtext1}
				<div class="redcms-clear"></div>
			</div>
			<div class="yui3-u-1-2">
				<div style="margin-left: 10px;">
					{foreach $this->getChildBlocks() as $b}
						{if $b->canRead()}
							{$b->render()}
						{/if}
					{/foreach}
				</div>
			</div>
		</div>
	</div>
{/block}