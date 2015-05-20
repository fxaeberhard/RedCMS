{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<style type="text/css">
  <!--
  .yui3-treeview-menu .yui3-treeleaf-content {
      text-decoration: underline;
  }
  -->
</style>

<div class="redcms-block yui3-redcms-loading yui3-treeview-menu" {$this->renderBlockAttributes()}
     widget="TreeView" requires="redcms-treeview">

  {function name=menu level=0}
      [
      {foreach $blocks as $block}

          {$link = $block->getLink()}
          {*            {if $block->canRead() AND ($link!= '#' OR  get_class($block) == 'Action')}*}
          {
            "redid": "{$block->id}",
            "label": "{urlencode("<i class='yui3-redcms-icon yui3-redcms-icon-html'></i>")}{$block->getLabel()}",
            "href": "{$block->getLink()}",
            "attrs": {
            "redid": {$block->id}, "widget": "{get_class($block)}"
          }

          {*  {$subBlocks = $block->getChildBlocks('number1')}
          {if !empty($subBlocks)}
          ,children: {call menu blocks=$subBlocks level=$level+1}
          {/if}
          *}
          },
          {*{/if}*}
      {/foreach}
      {}]
  {/function}

  {call menu blocks=$this->getChildBlocks('number1')}

  {if sizeof($childs) == 0}
      <center><em>There are no pages in this menu.</em></center>
      {else}
          {call tree blocks=$childs}
      {/if}
</div>

