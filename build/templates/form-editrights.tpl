{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<div redid="{$this->id}" widget="SimpleForm" requires="redcms-form" rootBlock="true" 
	redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" style="min-width: 200px;">
	<form action="{$this->getLink()}" method="post" class="yui3-redcms-form-content" >
		<input name="id" type="hidden" value="{$this->_targetBlock->id}">
		<div class="yui3-g">
				<div class="yui3-u-1-2" ></div>
				<div class="yui3-u-1-4 redcms-center"><b>Read</b></div>
				<div class="yui3-u-1-4 redcms-center"><b>Write</b></div>
		</div>
		<hr />
		<div class="yui3-g">
				<div class="yui3-u-1-2" >Global</div>
				<div class="yui3-u-1-4 redcms-center">
					<input name="read" type="checkbox" {if $this->_targetBlock->read === 1}checked{/if} />
				</div>
				<div class="yui3-u-1-4 redcms-center">
					<input name="write" type="checkbox" {if $this->_targetBlock->write === 1}checked{/if} />
				</div>
		</div>
		<hr />
		{foreach $this->getRightsByGroup($this->_targetBlock->id) as $g}
			<div class="yui3-g">
				<div class="yui3-u-1-2" >{$g['name']}</div>
				<div class="yui3-u-1-4 redcms-center">
					<input name="{$g['name']}_read" type="checkbox" {if $g['read'] === 1}checked{/if} />
				</div>
				<div class="yui3-u-1-4 redcms-center">
					<input name="{$g['name']}_write" type="checkbox" {if $g['write'] === 1}checked{/if} />
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
