<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

class PageBlock extends Block {
	
	function getLabel(){
		return $this->link;
	}
	function getLink(){
		$redCMS = RedCMS::get();
		if ($this->id === $redCMS->config['homePageId']) return ParamManager::getLink();
		else return parent::getLink();
	}
	function render() {
		$redCMS = RedCMS::get();
		global $_REQUEST;
		
		if (!isset($_REQUEST['redreload'])){
			//First render headers
			$template = $this->getTemplate();
			$template->display($redCMS->config['headerTemplate']);
			
			//Render page content
			$template = $this->getTemplate();
			$template->assign('reload', false);
			$template->assign('siteBlocks', BlockManager::getBlocksBySelect("parentId = -1"));
			$template->display($this->template);
			
			//First render headers
			$template = $this->getTemplate();
			$template->assign('footerBlocks', BlockManager::getBlocksBySelect("parentId = -2"));
			$template->display($redCMS->config['footerTemplate']);
		}else {
			
			//Render page content
			$template = $this->getTemplate();
			$template->assign('reload', true);
			$template->assign('siteBlocks', BlockManager::getBlocksBySelect("parentId = -1"));
			$template->display($this->template);
		}
	}
}
?>