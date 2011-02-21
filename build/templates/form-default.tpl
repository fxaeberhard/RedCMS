<form action="{$this->getLink()}" method="post" widget="Form" requires="redcms-form">{json_encode($this->getFormFields())}</form>

<!-- 
multipart/form-data
application/x-www-form-urlencoded
 -->