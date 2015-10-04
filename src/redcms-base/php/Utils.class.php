<?php

class Utils {

	// *** URL Encoding methods *** //
	static function url_encode($str) {
		return urlencode(str_replace(['/', '&'], ['%2F', 'AND'], $str));
	}

	static function url_decode($str) {
		return str_replace(['%2F', 'AND'], ['/', '&'], urldecode($str));
	}

	// *** Date methods *** //
	static function date_tomin($date) {
		return floor($date / (60));
	}

	static function date_tohours($date) {
		return floor($date / (60 * 60));
	}

	static function date_todays($date) {
		return floor($date / (60 * 60 * 24));
	}

	static function date_tomonth($date) {
		return ((date('Y', $date) - 1970) * 12 ) + date('n', $date);
	}

	static function date_toyear($date) {
		return ((date('Y', $date) - 1970) * 12 ) + date('n', $date);
	}

	static function date($dateFormat, $date = null) {
		if ($date == null)
			$date = time();
		if (!is_numeric($date))
			$date = strtotime($date);
		$redCMS = RedCMS::get();
		$dico = [
			"fr" => ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
			"en" => ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", "January", "Febrary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
		];
		return str_replace($dico['en'], $dico[$redCMS->lang], date($dateFormat, $date));
	}

	static function date_formatinterval($date1, $date2, $dateFormat = "d F Y") {
		$date1 = strtotime($date1);
		$date2 = strtotime($date2);
		if (Utils::date_todays($date1) === Utils::date_todays($date2) || !isset($date2) || $date2 == "") {
//			return 'le ' . Utils::date('j F Y, \d\e H:i', $date1) . ' à ' . date('H:i', $date2);
			return 'le ' . Utils::date('j F Y', $date1);
		} else if (Utils::date_tomonth($date1) === Utils::date_tomonth($date2) || !isset($date2) || $date2 == "") {
			return 'du ' . Utils::date('j', $date1) . ' au ' . Utils::date('j F Y', $date2);
		} else {
//			return 'du ' . Utils::date('j F à H:i', $date1) . ' au ' . Utils::date('j F Y à H:i', $date2);
			return 'du ' . Utils::date('j F', $date1) . ' au ' . Utils::date('j F Y', $date2);
		}
	}

	static function date_formatduration($date) {
		$now = time();
		$date = strtotime($date);
		$prefix = ($date > $now) ? 'dans ' : 'il y a ';
		$diff = abs(($now - $date) / 60);
		if ($diff < 60) {
			return $prefix . round($diff) . ' minutes';
		} elseif ($diff < (24 * 60)) {
//			return $prefix . floor($diff / 60) . ' heures et ' . round($diff % 60) . ' minutes';
			return $prefix . floor($diff / 60) . ' heures';
			//		}elseif ($diff < 2*24){
			//			return 'aujourd\'hui, à '. date('H:i', $date);
		} elseif ($diff < (2 * 24 * 60)) {
			//return (($date > $now) ? 'demain' : 'hier') . ', à ' . date('H:i', $date);
			return (($date > $now) ? 'demain' : 'hier');
		} else {
			return Utils::date('\l\e j F Y', $date);
//			return Utils::date('\l\e j F Y à H:i', $date);
		}
	}

	// *** File Functions *** //

	static function file_extension($filename) {
		$a = explode(".", $filename);
		return strtolower(end($a));
	}

	/**
	 * Return upload_max_filesize value from php.ini in kilobytes (function adapted from php.net)
	 */
	static function file_maxuploadsize() {
		$val = ini_get('upload_max_filesize');
		$val = trim($val);
		$last = strtolower($val{strlen($val) - 1});
		switch ($last) {// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
		}
		return $val;
	}

	static function file_isImage($file) {
		switch (Utils::file_extension($file)) {
			case 'jpg':
			case 'jpeg':
			case 'bmp':
			case 'gif':
			case 'png':
				return true;
			default: return false;
		}
	}

	static function file_getMimeType($ext) {
		$ext = Utils::file_extension($ext);
		switch ($ext) {
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

	// *** SQL FUNCTION *** //
	static function sql_date($date = null) {
		if (!$date) {
			$date = time();
		}
		return date('Y-m-d H:i', $date);
	}

}
