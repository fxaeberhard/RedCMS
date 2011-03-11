{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div {$this->renderBlockAttributes()} widget="SimpleForm" requires="redcms-form" style="min-width: 200px;" >
	
	<style type="text/css">
		.redcms-form-editgroups > .yui3-g {
			padding-right:60px;
		}
		.redcms-form-editgroups .right {
			margin-right: -60px;
			width: 60px;
		}
		
		.redcms-form-editgroups .left {
			width:100%;
		}
	</style>
	<form action="{$this->getLink()}" method="post" class="yui3-redcms-form-content redcms-form-editgroups" >
		<input name="id" type="hidden" value="{$this->_targetBlock->id}">
		<div class="yui3-g">
				<div class="yui3-u left" ></div>
				<div class="yui3-u right redcms-center"><b>Member</b></div>
		</div>
		<hr />
		{foreach $this->getGetGroupMemberShipByUser($this->_targetBlock->id) as $g}
			<div class="yui3-g">
				<div class="yui3-u left" >{$g['name']}</div>
				<div class="yui3-u right redcms-center">
					<input name="membership_{$g['idGroup']}" type="checkbox" {if $g['idUser']}checked{/if} />
				</div>
			</div>
		{/foreach}
		<hr />
		<div class="yui3-g">
				<div class="yui3-u-1-2" ></div>
				<div class="yui3-u-1-2">
					<input name="redaction" type="submit" value="Submit" />
				</div>
		</div>
	</form>
</div>
