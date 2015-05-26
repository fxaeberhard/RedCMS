<?php

class Logger {

	var $logWriters = [];
	var $verbose = ['log', 'info', 'warn', 'error'];
	var $startTime;

	function Logger() {
		$this->startTime = microtime(true);
	}

	function addLogWriter($logWriter) {
		array_push($this->logWriters, $logWriter);
	}

	function log($object, $verbose = 'log', $src = null) {
		foreach ($this->logWriters as &$lw) {
			$lw->write($object, $verbose, $src);
		}
	}

	function doCheckPoint($name = 'Checkpoint') {
		$add = '';
		if (function_exists('memory_get_usage')) {
			$add = "mem usage " . memory_get_usage();
		}
		echo $this->log($name . ":temps " . round(microtime(true) - $this->startTime, 4) . $add);
	}

}

class LogWriter {

	function write($verbose, $object, $src) {
		throw new NotImplementedException();
	}

	//	function getMessageString($object, $src){
	//		$ret = '['.(($src)?get_class($src):'global').']';
	//		if (is_string($object)) $ret .=  $object;
	//			else $ret .= print_r($object, true);
	//		return $ret;
	//	}
}

class FirePHPLogWriter extends LogWriter {

	var $firephp;

	function FirePHPLogWriter() {
		$this->firephp = FirePHP::getInstance(true);

		$this->firephp->setOptions(['maxObjectDepth' => 4,
			'maxArrayDepth' => 4,
			'useNativeJsonEncode' => true,
			'includeLineNumbers' => true]);
		//This line is present in firebug documentation, but seems to be unuseful for us
		//		ob_start();
	}

	function write($object, $verbose, $src) {
		$label = '[' . (($src) ? get_class($src) : 'global') . ']';
		try {
			switch ($verbose) {
				case 'log':
					$this->firephp->log($object, $label);
					break;
				case 'info':
					$this->firephp->info($object, $label);
					break;
				case 'warn':
					$this->firephp->warn($object, $label);
					break;
				case 'error':
					$this->firephp->error($object, $label);
					break;
			}
		} catch (Exception $e) {
			echo '[FirePHPLogger}Headers have alredy been sent.';
		}
	}

}

