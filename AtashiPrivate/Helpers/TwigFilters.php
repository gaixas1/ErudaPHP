<?php

namespace AtashiPrivate\Helpers;


class TwigFilters {
	static function parseTweet($text) {
		return self::parseHttp ( self::parseHashTag ( htmlspecialchars_decode ( $text ) ) );
	}
	static function parseHashTag($text) {
		if (preg_match ( "/#([0-9a-zA-Z]+)?/", $text, $url )) {
			$text = strtr ( $text, array (
					$url [0] => '<a class="hashTag" href="https://twitter.com/search?q=%23' . $url [1] . '&src=hash">#' . $url [1] . '</a>' 
			) );
		}
		return $text;
	}
	static function parseHttp($text) {
		if (preg_match ( "/ (http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*) ?/", $text, $url )) {
			$text = strtr ( $text, array (
					$url [0] => '<a href="' . $url [0] . '">' . $url [0] . '</a>' 
			) );
		}
		return $text;
	}
	static public function sanitizeFilter($text) {
		return str_replace ( '_', ' ', $text );
	}
	
	static public function link2facebookFilter($link, $title) {
		return 'https://www.facebook.com/sharer.php?' . http_build_query ( array (
				'u' => $link,
				't' => $title 
		) );
	}
	static public function link2twitterFilter($link, $title) {
		return 'http://twitter.com/?status=' . urlencode ( '#FSFansub ' . $title . ' >> ' . $link );
	}
}
