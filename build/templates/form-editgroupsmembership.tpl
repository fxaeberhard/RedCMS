{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<div redid="{$this->id}" widget="SimpleForm" requires="redcms-form" rootBlock="true" style="min-width: 200px;"
	redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" >
	<form action="{$this->getLink()}" method="post" class="yui3-redcms-form-content" >
		<input name="id" type="hidden" value="{$this->_targetBlock->id}">
		<div class="yui3-g">
				<div class="yui3-u-2-3" ></div>
				<div class="yui3-u-1-3 redcms-center"><b>Member</b></div>
		</div>
		{foreach $this->getGetGroupMemberShipByUser($this->_targetBlock->id) as $g}
			<div class="yui3-g">
				<div class="yui3-u-2-3" >{$g['name']}</div>
				<div class="yui3-u-1-3 redcms-center">
					<input name="{$g['name']}_membership" type="checkbox" {if $g['idUser']}checked{/if} />
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
