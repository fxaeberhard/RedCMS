{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

<form action="{$this->getLink()}" method="post" widget="Form" requires="redcms-form" redid="{$this->id}"
	redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" 
	redparams="{htmlspecialchars(json_encode($this->getParamsJSON()))}"
	class="" style="display:none;">{json_encode($this->getFormFields())}</form>