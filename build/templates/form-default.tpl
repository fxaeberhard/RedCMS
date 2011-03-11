{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<form action="{$this->getLink()}" method="post" widget="Form" requires="redcms-form" 
	{$this->renderBlockAttributes()}
	class="redcms-hidden">{urlencode(json_encode($this->getFormFields()))}</form>