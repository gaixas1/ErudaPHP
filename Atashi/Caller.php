<?php

namespace Atashi;

class Caller {
	public $ctrl;
	public $fun;
	public $params;
	public $t;
	function __construct($ctrl) {
		$this->t = explode ( '?', $ctrl );
		$tc = explode ( '::', $this->t [0] );
		
		if (count ( $tc ) == 1) {
			$this->ctrl = null;
			$this->fun = $tc [0];
		} else {
			$this->ctrl = $tc [0];
			$this->fun = $tc [1];
		}
	}
	function setParams($params) {
		$this->params = $params;
	}
	function computeParams($route, $params) {
		$this->params = array ();
		
		for($i = 1; $i < count ( $this->t ); $i ++) {
			$vl = explode ( '=', $this->t [$i] );
			if (count ( $vl ) == 2) {
				$this->params [$vl [0]] = $vl [1];
			}
		}
		for($i = 0; $i < count ( $route ); $i ++) {
			switch ($route [$i] [0]) {
				case TP_STRING :
				case TP_ANUM :
					$this->params [$route [$i] [1]] = $params [$i];
					break;
				case TP_INT :
					$this->params [$route [$i] [1]] = intval ( $params [$i] );
					break;
				case TP_DMY :
					$tp = explode ( '-', $params [$i] );
					$this->params [$route [$i] [1]] = new \DateTime ( $tp [2] . '-' . $tp [1] . '-' . $tp [0] );
					break;
				case TP_MY :
					$tp = implode ( '-', $params [$i] );
					$this->params [$route [$i] [1]] = new \DateTime ( $tp [2] . '-' . $tp [1] . '-0' );
					break;
				case TP_ALL :
					$this->params [$route [$i] [1]] = implode ( '/', array_slice ( $params, $i ) );
			}
		}
	}
	function execute(\Atashi\Core $atashi) {
		if ($this->ctrl !== null) {
			$controller = new $this->ctrl ( $atashi );
			$f = $this->fun;
			$controller->pre ( $this->params );
			while ( $f != null ) {
				$f = $controller->$f ( $this->params );
			}
			$controller->post ( $this->params );
		} else {
			$f = $this->fun;
			while ( $f != null ) {
				$f = $f ( $atashi, $this->params );
			}
		}
	}
}
