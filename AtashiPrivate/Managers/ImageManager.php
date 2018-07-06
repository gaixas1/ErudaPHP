<?php

namespace AtashiPrivate\Managers;

use AtashiPrivate\Entity\Image;

class ImageManager extends \Atashi\Manager {
	
	// Getters
	function getAll() {
		$entries = $this->em->getAll ( 'image', '*', null, "id DESC" );
		$ret = array ();
		foreach ( $entries as $entry ) {
			$ret [] = $this->parse ( $entry );
		}
		return $ret;
	}
	function getById($id) {
		$entry = $this->em->getOne ( 'image', '*', 'id = ' . $id );
		if ($entry != null) {
			return $this->parse ( $entry );
		}
		return null;
	}
	function getByCode($code) {
		$entry = $this->em->getOne ( 'image', '*', 'code = ' . $this->em->escape ( $code ) );
		if ($entry != null) {
			return $this->parse ( $entry );
		}
		return null;
	}
	
	// Parsers
	function parse($c) {
		$im = new Image ();
		
		$im->__set ( 'id', $c ['id'] );
		$im->__set ( 'code', $c ['code'] );
		
		return $im;
	}
}