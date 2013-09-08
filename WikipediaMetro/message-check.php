<?php

// Check which languages have complete win8 translations

$messages = explode("\n", 
"menu-language
menu-win8-pin
menu-win8-unpin
menu-open-browser
menu-about
table-show-infobox
table-show-meta
table-show
sitename
win8-tile-featured-article
section-featured-articles
section-featured-pictures
section-onthisday
section-recentchanges
sitename
error-not-available
error-offline-prompt");

function validateLanguage($filename) {
	global $messages;
	$required = array_flip($messages);
	$lines = file($filename);
	$found = 0;
	foreach ($lines as $line) {
		if (preg_match('/^([\w-]+)\s*=/', $line, $matches)) {
			$msg = $matches[1];
			if (isset($required[$msg])) {
				$found++;
				unset($required[$msg]);
			}
		}
	}
	if (count($required) > 0) {
		print "$filename is missing:\n";
		foreach ($required as $msg => $key) {
			print "    $msg\n";
		}
	} else {
		print "$filename is complete!\n";
	}
}

$files = glob("../assets/www/messages/*.properties");
foreach ($files as $file) {
	validateLanguage($file);
}
