<?php

/*
  Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
  Code licensed under the BSD License:
  http://redcms.red-agent.com/license.html
 */

class ParamManager {

	var $parameters = [];

	function ParamManager() {
		global $_REQUEST;
		$redCMS = RedCMS::get();
		if (isset($_REQUEST['q'])) {
			$redirUrl = $_REQUEST['q'];
			if ($redCMS->path != '/') {
				$redirUrl = str_replace($redCMS->path, '', $redirUrl);
			}

			$args = explode('/', $redirUrl);
			foreach ($args as &$arg) {
				if ($arg != '') {
					$this->parameters[] = Utils::url_decode($arg);
				}
			}
		}
		if (isset($_REQUEST['p1'])) {
			$this->parameters[] = Utils::url_decode($_REQUEST['p1']);
		}
	}

	function hasMore() {
		return count($this->parameters) > 0;
	}

	function &current() {
		return $this->parameters[0];
	}

	function currentStackJSON($startIndex = 1) {
		$ret = [];
		foreach ($this->parameters as $p) {
			$ret['p' . $startIndex] = Utils::url_encode($p);
			++$startIndex;
		}
		return $ret;
	}

	function next() {
		return array_shift($this->parameters);
	}

	static function &getLink($param1 = null, $param2 = null, $param3 = null, $param4 = null) {
		$redCMS = RedCMS::get();
		$ret = $redCMS->path;
		//echo $redCMS->config['defaultLang']."**".$redCMS->lang;
		if ($param1 && $redCMS->config['defaultLang'] != $redCMS->lang) {
			$ret .= $redCMS->lang . "/";
		}
		if ($param1) {
			$ret .= Utils::url_encode($param1) . "/";
		}
		if ($param2) {
			$ret .= Utils::url_encode($param2) . "/";
		}
		if ($param3) {
			$ret .= Utils::url_encode($param3) . "/";
		}
		if ($param4) {
			$ret .= Utils::url_encode($param4) . "/";
		}

		return $ret;
	}

}
