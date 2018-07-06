<?php

namespace Atashi;

class Controller {
	/** @var Core $atashi */
	public $atashi;
	/** @var DBObject $em */
	public $em;
	/** @var boolean $mobile */
	public $mobile;
	public function __construct(\Atashi\Core $atashi) {
		$this->atashi = $atashi;
		$this->em = $atashi->em;
		
		$device = $atashi->getRequest ( 'device', null );
		if ($device === null) {
			$device = $atashi->getCookie ( 'device', $atashi->getSession ( 'device', null ) );
		}
		if ($device === null) {
			$isMobile = false;
			if (isset ( $_SERVER ['HTTP_USER_AGENT'] )) {
				$isMobile = ( bool ) preg_match ( '#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet' . '|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]' . '|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER ['HTTP_USER_AGENT'] );
			}
			if ($isMobile) {
				$device = 'MOBILE';
			} else {
				$device = 'PC';
			}
		}
		
		$this->mobile = strcasecmp ( $device, 'MOBILE' ) == 0;
		$atashi->setCookie ( 'device', $this->mobile ? 'MOBILE' : 'PC' );
		$atashi->setSession ( 'device', $this->mobile ? 'MOBILE' : 'PC' );
	}
	public function pre($params = array()) {
	}
	public function post($params = array()) {
	}
}