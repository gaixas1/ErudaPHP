<?php

namespace Atashi;

class Cron {
	public $atashi;
	public $em;
	public function __construct(\Atashi\Core $atashi) {
		$this->atashi = $atashi;
		$this->em = $atashi->em;
	}
	public function call() {
	}
}