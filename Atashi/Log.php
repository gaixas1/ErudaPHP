<?php

namespace Atashi;

class Log {
	public static $vals = array ();
	static function add($l) {
		Log::$vals [] = $l;
	}
	static function view() {
		echo '<div class="log">';
		foreach ( Log::$vals as $l ) {
			echo '<p>' . $l . '</p>';
		}
		echo '</div>';
	}
}
