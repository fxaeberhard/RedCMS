{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*}
<div class="redcms-block" redid="{$this->id}" redadmin="{htmlspecialchars(json_encode($this->getAdminJSON()))}" 
	widget="TreeView" requires="redcms-treeview" >
	<ul>
		{foreach $this->getChildBlocks() as $block}
			<li redid="{$block->id}" widget="User">	
				<a href="#">
					{if $block->name}
						{$block->name} {$block->surname}
					{else}{$block->userName}{/if}
						</a>
				<ul>
					<div class="yui3-g">
				        <div class="yui3-u-1-2" id="nav">
							<fieldset>
								<legend>Profile</legend>
								{$block->name} {$block->surname}<br />
								{$block->text1}
							</fieldset>
						</div>
				        <div class="yui3-u-1-2" id="main">
				 			<fieldset>
								<legend>Contact</legend>
								{if $block->email NEQ ''}
									<a href="mailto:{$block->get('email')}">
										{$block->email}
									</a>
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
							</fieldset>
				        </div>
				    </div>
					{if $block->adress != ''}
				    <div class="yui3-g">
				        <div class="yui3-u-1-2" id="nav">
							<fieldset>
								<legend>Private Adress</legend>
								{$block->adress}<br />
								{$block->adress_zip} {$block->get('adress_city')}<br />
								{$block->adress_country}
							</fieldset>
				        </div>
				        <div class="yui3-u-1-2" id="main">
							<fieldset>
								<legend>Professionnal Adress</legend>
								{$block->adresspro}<br />
								{$block->adresspro_zip} {$block->adresspro_city}<br />
							</fieldset>
				        </div>
				    </div>
				    {/if}
		        </ul> 
			</li>
		{/foreach}
	</ul>
</div>