{extends file="page-smag.tpl"}

{block name="bd"}

	<div class="redcms-bd-content" widget="Block" {$this->renderBlockAttributes()} >
		<div class="yui3-g">
			<div class="yui3-u-1-2">
				<div style="margin-right: 7px;">
					{$this->longtext1}
					<div class="redcms-clear"></div>
				</div>
			</div>
			<div class="yui3-u-1-2">
				<div style="margin-left: 7px;">
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