{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<div widget="Form" data-cfg='{urlencode('{"action":"')}{urlencode($this->getLink())}{urlencode('"}')}'  requires="redcms-form" 
     {$this->renderBlockAttributes()} class="redcms-hidden">
  {urlencode(json_encode($this->getFormFields()))}
</div>