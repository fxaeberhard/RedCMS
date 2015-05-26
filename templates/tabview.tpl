{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<div class="redcms-block yui3-redcms-loading" {$this->renderBlockAttributes()}
     widget="TabView" requires="redcms-tabview" data-noover=true >
  
	{$childs = $this->getChildBlocks()}
	
	<div id="demo">
		<ul>
			{foreach $childs as $b}
				<li><a href="#tab">$b->getLabel()</a></li>
			{/foreach}
		</ul>
		<div>
			{foreach $childs as $b}
				<div id="tab">{$b->render()}</div>
			{/foreach}
		</div>
	</div>
</div>