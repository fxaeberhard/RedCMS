{*
* Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
* Code licensed under the BSD License:
* http://redcms.red-agent.com/license.html
*}

<div class="redcms-block" {$this->renderBlockAttributes()}
     widget="Accordion" requires="redcms-accordion" >

  <button class='yui3-button' widget='OpenPanelAction' params='{ "parentId":9 }' href="/RedCMS/150/" data-cfg='{ "onSuccessEvent": "dirty" }'><i class='fa fa-plus-square'></i> Create user</button>
  <br /><br />

  <ul>
    {foreach $this->getChildBlocks() as $block}
        <li redid="{$block->id}" widget="User">	
          <a href="#" class="yui3-redcms-accordion-title">
						<span class="redcms-icon-user"></span>{$block->getLabel()}</a>
          <ul class="yui3-redcms-accordion-item">
            {include file="user-default.tpl" inline}
          </ul> 
        </li>
    {/foreach}
  </ul>
</div>