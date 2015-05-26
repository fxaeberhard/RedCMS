{extends file="page-default.tpl"}

{block name="stylesheets"}
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
          - Dernière mise à jour {Utils::date_formatduration($redCMS->getLastUpdate())}
			{*{$redCMS->getLastUpdate()|date_format:"%e %b %Y"}*}
		  
          - Visiteurs {$redCMS->sessionManager->getVisitorCount()}
        </div>
      </div>
      <div class="redcms-clear"></div>
    </div>
    <div class="smag-subfooter"></div>
{/block}

{block name='ft-content'} {/block}