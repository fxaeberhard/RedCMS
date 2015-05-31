{*
* Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
* Code licensed under the BSD License:
* http://redcms.red-agent.com/license.html
*}
<div class=" redcms-user">
  <div class="yui3-g">
    <div class="yui3-u-1-2">
      <fieldset>
        <legend>Profile</legend>
        <img src="http://www.gravatar.com/avatar/{md5(strtolower($block->email))}?s=80&d=mm" style="float: left;margin-right: 10px;border:1px solid gray"/>
        {$block->name} {$block->surname}<br />
                {$block->text1}
                </fieldset>
            </div>
            <div class="yui3-u-1-2">
              <fieldset>
                <legend>Contact</legend>
                {if $block->email NEQ ''}
                    <a href="mailto:{$block->get('email')}">
                      <div class="redcms-icon redcms-icon-email"><span></span>{$block->email}</div>
                    </a>
                    <div class="redcms-clear"></div>
                {/if}
                {if $block->pPhone NEQ ''}
                    Tél.: {$block->pPhone}<br />
                {/if}
                {if $block->prPhone NEQ ''}
                    Tél. prof.: {$block->prPhone}<br />
                {/if}
                {if $block->poPhone NEQ ''}
                    Tél. mobile: {$block->poPhone}<br />
                {/if}
                {*{if $block->userName NEQ ''}
                    Username: {$block->userName}<br />
                {/if}*}
              </fieldset>
            </div>
        </div>
        {if $block->adress != ''}
            <div class="yui3-g">
              <div class="yui3-u-1-2">
                <fieldset>
                  <legend>Adresse privée</legend>
                  {$block->adress}<br />
                      {$block->adress_zip} {$block->get('adress_city')}<br />
                              {$block->adress_country}
                              </fieldset>
                          </div>
                          <div class="yui3-u-1-2">
                            <fieldset>
                              <legend>Adresse professionnelle</legend>
                              {$block->adresspro}<br />
                                  {$block->adresspro_zip} {$block->adresspro_city}<br />
                                      </fieldset>
                                  </div>
                              </div>
                              {/if}
                              </div>
