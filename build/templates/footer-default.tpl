<div id="ft">
	{foreach $footerBlocks as $b}
		{$b->render()}
	{/foreach}
</div>

{* YUI Seed *}
<script type="text/javascript" src="http://yui.yahooapis.com/combo?3.3.0pr3/build/yui/yui-min.js&3.3.0pr3/build/loader/loader-min.js"></script>
<script type="text/javascript" src="{$redCMS->path}src/redcms-base/js/redcms-bootstrap.js"></script>

<script type="text/javascript" > 
var Config = {
	path : "{$redCMS->path}",
	loggedIn : {json_encode($redCMS->sessionManager->isLoggedIn())},
	lang : '{$redCMS->lang}',
	debug : {json_encode($redCMS->config['debugMode'])},
};
Y.namespace('RedCMS').Config = Config;
</script>
</body></html>