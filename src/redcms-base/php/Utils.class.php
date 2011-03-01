<?php
class Utils {
	
	static function url_encode($str){
		return urlencode(str_replace(array('/', '&'), array('%2F', 'AND'), $str));
	}
	static function url_decode($str){
		return str_replace(array( '%2F', 'AND'),array( '/','&'), urldecode($str));
	}

	static function date_tomin($date){
		return floor($date/ (60));
	}
	static function date_tohours($date){
		return floor($date/ (60*60));
	}
	static function date_todays($date){
		return floor($date/ (60*60*24));
	}
	static function date_tomonth($date){
		return ((date('Y', $date) - 1970) * 12 )+date( 'n', $date);
	}
	static function date_toyear($date){
		return ((date('Y', $date) - 1970) * 12 )+date( 'n', $date);
	}
	
	// *** File Functions *** //
	
	static function file_extension($filename){
		return end(explode(".", $filename));
	}

	/**
	 * Return upload_max_filesize value from php.ini in kilobytes (function adapted from php.net)
	 */
	static function file_maxuploadsize(){
		$val = ini_get('upload_max_filesize');
		$val = trim($val);
		$last = strtolower($val{strlen($val)-1});
		switch($last) {// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
		}
		return $val;
	}
	static function file_isImage($file){
		switch (Utils::file_extension($file)){
			case 'jpg':
			case 'jpeg':
			case 'bmp':
			case 'gif':
			case 'png':
				return true;
				break;
			default: return false;
		}
	}
	static function file_getMimeType($ext){
		$ext = Utils::file_extension($ext);
		switch ($ext){
			case 'jpg':
			case 'jpeg':
			case 'jpe': return'image/jpg';
			case 'png': return'image/png';
			case 'gif': return 'image/gif';
			case 'js': return 'application/x-javascript';
			case 'css': return 'text/css';
			case "mp3": return "audio/mpeg";
			case "mpg": return "video/mpeg";
			case "avi": return "video/x-msvideo";
			case "wmv": return "video/x-ms-wmv";
			case "wma": return "audio/x-ms-wma";
			default: return "application/force-download";
		}
	}
}
?>