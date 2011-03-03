{extends file="page-default.tpl"}

{block name="stylesheets"}
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?3.3.0/build/cssfonts/fonts-min.css&3.3.0/build/cssreset/reset-min.css&3.3.0/build/cssgrids/grids-min.css&3.3.0/build/cssbase/base-min.css&3.3.0pr3/build/widget/assets/skins/sam/widget.css&3.3.0pr3/build/node-menunav/assets/skins/sam/node-menunav.css&" charset="utf-8" />
	<meta id="customstyles" />
	<link rel="stylesheet" type="text/css" href="{$redCMS->path}src/redcms-base/assets/default-skin.css" />
	<link rel="stylesheet" type="text/css" href="{$redCMS->path}src/smag/assets/smag.css" />
{/block}
		
{block name='header'}{/block}

{block name='bd-header'}
<div class="smag-header">
	<div>
		<div class="smag-header-left"></div>
		<div class="smag-header-right"></div>
		<div class="redcms-clear"></div>
	</div>
</div>
{/block}

{block name='bd-footer'}
<div class="smag-footer">
	<div class="smag-footer-content">
		<div class="smag-footer-left"></div>
		<div class="smag-footer-center">
			SMAG-Societé des Médecins Anesthésistes Genevois - 
			<a href="mailto:contact@smagonline.ch">contact@smagonline.ch</a>
			- Dernière mise à jour: 28.02.11
			- Visiteur 8637
		</div>
	</div>
	<div class="redcms-clear"></div>
</div>
<div class="smag-subfooter"></div>
{/block}