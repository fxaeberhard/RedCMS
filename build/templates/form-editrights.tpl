{* 
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}

<div redid="{$this->id} redcms-editrights" widget="SimpleForm" requires="redcms-form" rootBlock="true" 
	redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" style="min-width: 200px;">
	
	<style type="text/css">
		.redcms-form-editrights > .yui3-g {
			padding-right:80px;
		}
		.redcms-form-editrights .right {
			margin-right: -80px;
			width: 80px;
		}
		
		.redcms-form-editrights .left {
			width:100%;
		}
	</style>
	
	<form action="{$this->getLink()}" method="post" class="yui3-redcms-form-content redcms-form-editrights" >
		<input name="id" type="hidden" value="{$this->_targetBlock->id}">
		<div class="yui3-g">
			<div class="yui3-u left" > </div>
			<div class="yui3-u right">
				<div class="yui3-g">
					<div class="yui3-u-1-2 redcms-center"><b>Read</b></div>
					<div class="yui3-u-1-2 redcms-center"><b>Write</b></div>
				</div>
			</div>
		</div>
		<hr />
		<div class="yui3-g">
			<div class="yui3-u left" >Public on the web</div>
				<div class="yui3-u right">
					<div class="yui3-g">
						<div class="yui3-u-1-2 redcms-center">
							<input name="publicread" type="checkbox" {if $this->_targetBlock->publicread === 1}checked{/if} />
						</div>
						<div class="yui3-u-1-2 redcms-center">
							<input name="publicwrite" type="checkbox" {if $this->_targetBlock->publicwrite === 1}checked{/if} />
					</div>
				</div>
			</div>
		</div>
		<div class="yui3-g">
		
			<div class="yui3-u left" >Registered users</div>
			<div class="yui3-u right">
				<div class="yui3-g">
					<div class="yui3-u-1-2 redcms-center">
						<input name="read" type="checkbox" {if $this->_targetBlock->read === 1}checked{/if} />
					</div>
					<div class="yui3-u-1-2 redcms-center">
						<input name="write" type="checkbox" {if $this->_targetBlock->write === 1}checked{/if} />
					</div>
				</div>
			</div>
		</div>
		<hr />
		{foreach $this->getRightsByGroup($this->_targetBlock->id) as $g}
			<div class="yui3-g">
				<div class="yui3-u left" >{$g['name']}</div>
				<div class="yui3-u right">
					<div class="yui3-g">
						<div class="yui3-u-1-2 redcms-center"><input name="read_{$g['idGroup']}" type="checkbox" {if $g['read'] === 1}checked{/if} /></div>
						<div class="yui3-u-1-2 redcms-center"><input name="write_{$g['idGroup']}" type="checkbox" {if $g['write'] === 1}checked{/if} /></div>
					</div>
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
