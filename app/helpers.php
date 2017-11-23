<?php

use App\Page;
use App\CalendarEvent;

function locales() {
	return config('app.locales');
}

function page($page = null, $l = null) {
	$link = "";

	if (!isset($l)) {
	 	$l = \App::getLocale();
	}

	// $link .= $l . '/';

	if (isset($page) && $page->id != 1) {
		$link .= redurlencode($page['name_' . $l]);
	}

	if ($link == 'en') {
		$link = '';
	}

	return url($link);
}

function pageById($pageId) {
	return page(Page::find($pageId));
}

function prefered_language(array $available_languages, $http_accept_language) {
	$available_languages = array_flip($available_languages);
	$langs;
	preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
	foreach ($matches as $match) {

		list($a, $b) = explode('-', $match[1]) + array('', '');
		$value = isset($match[2]) ? (float) $match[2] : 1.0;

		if (isset($available_languages[$match[1]])) {
			$langs[$match[1]] = $value;
			continue;
		}

		if (isset($available_languages[$a])) {
			$langs[$a] = $value - 0.1;
		}

	}
	arsort($langs);

	return $langs;
}

function pagesList() {
	$r = [];

	$pages = Page::orderBy('name_' . \App::getLocale())->get();

	foreach ($pages as $p) {
		$r[$p['id']] = $p->name();
	}
	return $r;
}

function extension($f) {
	return pathinfo($f, PATHINFO_EXTENSION);
}

function filename($f) {
	$ext = extension($f);
	return str_replace(".$ext", '', basename($f));
}

function redurlencode($u) {
	return str_replace(['/'], ['--'], $u);
}
function redurldecode($u) {
	return str_replace(['--'], ['/'], $u);
}

function formatDate($d) {
	$d = new DateTime($d);
	return $d->format("j F Y");
}

function formatPeriod($d1, $d2) {
	$d1 = new DateTime($d1);
	$d2 = new DateTime($d2);

  if ($d1->format('Y-m-d') === $d2->format('Y-m-d')) {
		// Same day
		return "le " . $d1->format("j F Y") . ", de " . $d1->format('H:i') . ' à ' . $d2->format('H:i');
	} else if ($d1->format('Y-m') === $d1->format('Y-m')) {
		// Same month
		return "du " . $d1->format("j") . " au " . $d2->format("j F Y");
	} else {
		return "du " . $d1->format("j F Y") . " au " . $d2->format("j F Y");
	}
}

// function myencode($f) {
// 	return str_replace("©", "%A9", $f);
// }

function importCongresses($id) {
	importCongresses2($id, "http://www.sgar-ssar.ch/fr/informations-pour-des-anesthesistes/calendrier-des-congres/");
	importCongresses2($id, "http://www.sgar-ssar.ch/fr/informations-pour-des-anesthesistes/calendrier-des-congres/browse/1/");
	importCongresses2($id, "http://www.sgar-ssar.ch/fr/informations-pour-des-anesthesistes/calendrier-des-congres/browse/2/");
	importCongresses2($id, "http://www.sgar-ssar.ch/fr/informations-pour-des-anesthesistes/calendrier-des-congres/browse/3/");
}

function importCongresses2($id, $url) {
	$F = "Y-m-d H:i:s";

	libxml_use_internal_errors(true);
	$doc = new DOMDocument();
	$doc->loadHTMLFile($url);
	$finder = new DomXPath($doc);
	$nodes = $finder->query("//*[@class='news-list-item']");
	// echo $doc->saveHTML();

	foreach ($nodes as $n) {
		$title =  $finder->query(".//h2", $n)->item(0)->nodeValue;
		$description =  $finder->query(".//p", $n)->item(0)->nodeValue;
		$date =  $finder->query(".//*[@class='event_date']", $n)->item(0)->nodeValue;
		$location =  str_replace('Location: ', '', $finder->query(".//*[@class='event_location']", $n)->item(0)->nodeValue);
		echo $title. " ". $date . "<br />";

		if (strpos($date, ',') !== false) {
			$d = explode(",", $date);
			$d2 = DateTime::createFromFormat('d.m.y', $d[0]);
			$r = explode(' à ', $d[1]);
			$t = explode(':', $r[0]);
			$d1 = $d2->setTime($t[0], str_replace('h', '', $t[1]))->format($F);
			$t = explode(':', $r[1]);
			$d2 = $d2->setTime($t[0], str_replace('h', '', $t[1]))->format($F);
		} else {
			$d = explode(" à ", $date);
			$d1 = DateTime::createFromFormat('d.m.y', $d[0])->setTime(0,0)->format("Y-m-d H:i:s");
			$d2 = DateTime::createFromFormat('d.m.y', $d[1])->setTime(0,0)->format("Y-m-d H:i:s");
		}

		$e = CalendarEvent::where('title', $title)->where('date', $d1)->first();
		if (!isset($e)) {
			$n = new CalendarEvent;
			$n->calendar_id = $id;
			$n->title = $title;
			$n->description = $description;
			$n->date = $d1;
			$n->dateend = $d2;
			$n->location = $location;
			$n->save();
			echo "Inserted<br />";
		} else {
			echo "Already exists<br />";
		}
	}
}
