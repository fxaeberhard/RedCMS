{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

{$class=''}
{if $redCMS->sessionManager->getCurrentUser()->isAMember('1') OR $redCMS->sessionManager->getCurrentUser()->isAMember('2')}
    {$class='yui3-redcms-canwrite'}
{/if}

<div class="redcms-block {block name=blockClass}{/block} {$class}" {$this->renderBlockAttributes()}
     widget="MenuNav" requires="redcms-menunav" data-noover=true >

  <div class="yui3-menu-bd"></div>

  <div class="yui3-menu {block name=firstLevelClass}{/block}">
    <div class="yui3-menu-content">
      <div class="yui3-menu-hd">{block name=header}{/block}</div>
      {function name=menu level=0}
          <ul class="first-of-type">
            {foreach $blocks as $block}
                {if $block->canRead()}
                    {$isCategory = (get_class($block) == 'Action')}

                    {$liClass=(!$isCategory)?'class="yui3-menuitem"':''}
                    {$aClass=(!$isCategory)?'yui3-menuitem-content':'yui3-menu-label'}

                    <li {$liClass} redid="{$block->id}"  widget="{get_class($block)}">
                      <a class="{$aClass}" href="{$block->getLink()|default:'#'}">{$block->getLabel()|default:'No label'}</a>

                      {if $isCategory}
                          <div class="yui3-menu yui3-menu-hidden">
                            <div class="yui3-menu-content">
                              {call menu blocks=$block->getChildBlocks('number1') level=$level+1}
                            </div>
                          </div>
                      {/if}
                    </li>
                {/if}
            {foreachelse}	
                {*<li class="yui3-menuitem yui3-menuitem-empty">
                <a ><em>No items in this category</em></a>
                </li>*}
            {/foreach}
          </ul>
      {/function}
      {call menu blocks=$this->getChildBlocks('number1')}
    </div>
  {block name="footer"}{/block}
</div>

<div class="yui3-menu-ft"></div>

</div>