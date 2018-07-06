<?php

namespace AtashiPrivate\Controllers;

class Main extends BasicController {
	function admin($params = array()) {
		$admin = $this->atashi->getGlobal ( 'adminUrl', "" );
		if ($admin != "") {
			$this->atashi->redirect ( $admin );
		} else {
			$this->atashi->trigger500 ( "Error." );
		}
	}
	
	function home($params = array()) {
		$params ['pag'] = 1;
		$this->homePag ( $params );
	}
	function pag($params = array()) {
		$pag = $params ['pag'];
		
		if($pag <= 1 ){
			$this->data ['title'] = 'Home page'; 
		} else {
			$this->data ['title'] = 'Page '.$pag; 
		}
		
		if ($this->mobile) {
			$this->data ['title'] .= ' - Mobile';
		} 
	
		$this->atashi->render ( '/Default/index.html.twig', $this->data );
	}
}
