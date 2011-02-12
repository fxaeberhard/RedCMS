{* YUI Seed *}
<script type="text/javascript" src="http://yui.yahooapis.com/combo?3.3.0/build/yui/yui-min.js&3.3.0/build/loader/loader-min.js"></script>
<script type="text/javascript" src="{$redCMS->path}src/redcms-base/js/redcms-base.js"></script>

<script type="text/javascript" > 
var Config = {
	path : "{$redCMS->path}",
	loggedIn : {json_encode($redCMS->sessionManager->isLoggedIn())},
	lang : 'fr',
	debug : {json_encode($redCMS->config['debugMode'])},
};
Y.namespace('RedCMS').Config = Config;
</script>

</body></html>