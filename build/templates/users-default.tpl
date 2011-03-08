{*
 * Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
 * Code licensed under the BSD License:
 * http://redcms.red-agent.com/license.html
 *}
 
<div class="redcms-block" redid="{$this->id}" redadmin="{$this->renderAdminJSON()}" widget="Block">
	{foreach $this->getChildBlocks() as $block}
		{include file="user-default.tpl" inline}
	{/foreach}
</div>