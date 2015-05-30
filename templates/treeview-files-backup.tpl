{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}

{extends file="treeview-files.tpl"}

{block name="buttons"}
	<button class='yui3-button' widget="AsyncRequestAction" params='{ "parentId" : 11 }' href="{$redCMS->path}backupManager/"  data-cfg='{ "fires": "dirty" }'>
		<i class='fa fa-plus-square'></i> Create backup</button>

	<button class='yui3-button' widget='OpenPanelAction' params='{ "parentId":11 }' href="{$redCMS->path}320/" data-cfg='{ "onSuccessEvent": "dirty" }'>
		<i class='fa fa-upload'></i> Upload backup</button>
{/block}

{block name="orderby"}dateAdded DESC{/block}
