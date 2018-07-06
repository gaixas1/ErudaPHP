<?php

namespace Atashi;

class Manager {
	
	/** @var DBObject $em */
	public $em;
	public function __construct(DBObject $em) {
		$this->em = $em;
	}
	public function arrayToList($collection, $escape = true) {
		if ($escape) {
			foreach ( $collection as $k => $item ) {
				$collection [$k] = $this->em->escape ( $item );
			}
		}
		return " (" . implode ( ', ', $collection ) . ') ';
	}
	public function escape($value) {
		return $this->em->escape ( $value );
	}
}
