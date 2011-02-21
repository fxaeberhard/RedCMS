{* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*}
{$admin = $this->getLinkedBlock('admin')}
{$admin = (isset($admin))?$admin->getMenuItems():array()}
<div class="redcms-block" redid="{$this->id}" redadmin="{htmlspecialchars(json_encode($admin))}" 
	widget="TreeView" requires="redcms-treeview" >
	<ul>
		{foreach $this->getChildBlocks() as $block}
			<li redid="{$block->id}" widget="User">	
				<a href="#">
					{if $block->get('name')}
						{$block->fields['name']} {$block->fields['surname']}
					{else}{$block->get('userName')}{/if}
						</a>
				<ul>
					<div class="yui3-g">
				        <div class="yui3-u-1-2" id="nav">
							<fieldset>
								<legend>Profile</legend>
								{$block->get('name')} {$block->get('surname')}<br />
								{$block->get('text1')}
							</fieldset>
						</div>
				        <div class="yui3-u-1-2" id="main">
				 			<fieldset>
								<legend>Contact</legend>
								{if $block->get('email') NEQ ''}
									<a href="mailto:{$block->get('email')}">
										{$block->get('email')}
									</a>
								{/if}
								{if $block->get('pPhone') NEQ ''}
									Tél.: {$block->block('pPhone')}<br />
								{/if}
								{if $block->get('prPhone') NEQ ''}
									Tél. prof.: {$block->get('prPhone')}<br />
								{/if}
								{if $block->get('poPhone') NEQ ''}
									Tél. mobile: {$block->get('poPhone')}<br />
								{/if}
							</fieldset>
				        </div>
				    </div>
					{if $block->get('adress') != ''}
				    <div class="yui3-g">
				        <div class="yui3-u-1-2" id="nav">
							<fieldset>
								<legend>Private Adress</legend>
								{$block->get('adress')}<br />
								{$block->get('adress_zip')} {$block->get('adress_city')}<br />
								{$block->get('adress_country')}
							</fieldset>
				        </div>
				        <div class="yui3-u-1-2" id="main">
							<fieldset>
								<legend>Professionnal Adress</legend>
								{$block->get('adresspro')}<br />
								{$block->get('adresspro_zip')} {$block->get('adresspro_city')}<br />
							</fieldset>
				        </div>
				    </div>
				    {/if}
		        </ul> 
			</li>
		{/foreach}
	</ul>
</div>