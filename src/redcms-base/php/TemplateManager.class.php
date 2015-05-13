<?php

/*
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

class TemplateManager {

    static function &getTemplate() {
        $redCMS = RedCMS::getInstance();

        $smarty = new Smarty();
        $smarty->template_dir = $redCMS->fullpath . "templates";
        $smarty->compile_dir = $redCMS->fullpath . "files/smarty/template_c";
        $smarty->cache_dir = $redCMS->fullpath . "files/smarty/cache";
        $smarty->config_dir = $redCMS->fullpath . "files/smarty/config";

        $smarty->assign('redCMS', $redCMS);
        return $smarty;
    }

}

?>