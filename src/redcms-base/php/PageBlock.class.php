<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

class PageBlock extends Block {
	
	function getLabel(){
		if ($this->link) return $this->link;
		else return parent::getLabel();
	}
	function getLink(){
		$redCMS = RedCMS::get();
		if ($this->id === $redCMS->config['homePageId']) return ParamManager::getLink();
		else return parent::getLink();
	}
	function getSiteBlocks(){
		return  BlockManager::getBlocksBySelect("parentId = -1");	
	}
	function getFooterBlocks(){
		return BlockManager::getBlocksBySelect("parentId = -2");
	}
	function render() {
		$redCMS = RedCMS::get();
		global $_REQUEST;
		
		//Render page content
		$template = $this->getTemplate();
		$template->assign('reload', isset($_REQUEST['redreload']));
		$template->display($this->template);
	}
}
?>