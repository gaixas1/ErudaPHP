<?php

namespace AtashiPrivate\Entity;

use Atashi\Entity;

class Image extends Entity {
	public $code;
	function __construct() {
		parent::__construct ();
		$this->code = '';
	}
}
