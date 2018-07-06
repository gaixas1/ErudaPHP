<?php

namespace Atashi;

class Entity {
	public $id;
	public $created;
	public $updated;
	function __construct() {
		$this->id = 0;
		$this->created = new \DateTime ();
		$this->updated = new \DateTime ();
	}
	public function __set($name, $value) {
		$this->$name = $value;
		return $this;
	}
	public function __get($name) {
		return $this->name;
	}
	function setCreated($t) {
		$this->created = new \DateTime ( $t );
	}
	function setUpdated($t) {
		$this->updated = new \DateTime ( $t );
	}
	public function canonicalize($src, $dst = null, $maxL = 50) {
		if ($dst == null) {
			$dst = $src;
		}
		$s = mb_strtolower ( $this->$src, 'UTF-8' );
		$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
				'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'Ny', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
				'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
				'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'ny', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
				'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
		$s = strtr( $s, $unwanted_array );
		
		$s = preg_replace ( '~.*;~', '', $s );
		$s = preg_replace ( "~&~", "and", $s );
		$s = preg_replace ( "~\?~", "", $s );
		$s = preg_replace ( "~!~", "", $s );
		$s = preg_replace ( "~�~", "", $s );
		$s = preg_replace ( "~�~", "", $s );
		$s = preg_replace ( '~#~', "", $s );
		$s = preg_replace ( '~�~', "", $s );
		$s = preg_replace ( '~\$~', "", $s );
		$s = preg_replace ( "~(\\\|/|>|<|\?)+~", "-", $s );
		$s = strtr ( $s, ":", "-" );
		$s = strtr ( $s, "'", "-" );
		$s = strtr ( $s, '"', "-" );
		$s = strtr ( $s, "(", "-" );
		$s = strtr ( $s, ")", "-" );
		$s = strtr ( $s, ",", "_" );
		$s = strtr ( $s, " ", "_" );
		$s = filter_var ( $s, FILTER_SANITIZE_URL );
		$s = urldecode ( $s );
		$s = strtr ( $s, " ", "_" );
		$s = preg_replace ( "~__+~", "_", $s );
		if (strlen ( $s ) > $maxL) { $s = substr ( $s, 0, $maxL ); }
		$this->$dst = rawurlencode ( $s );
	}
}
