<?php

namespace AtashiPrivate\Controllers;

class Contact extends BasicController {
	function pre($params = array()) {
		parent::pre ( $params );
	}
	function form($params = array()) {
		$this->data ['sended'] = $this->atashi->getSession ( 'sended', false );
		$this->data ['mail'] = $this->atashi->getSession ( 'mail', "" );
		$this->data ['text'] = $this->atashi->getSession ( 'text', "" );
		
		$this->atashi->setSession ( 'mail', "" );
		$this->atashi->setSession ( 'text', "" );
		$this->atashi->setSession ( 'sended', false );
		
		$this->atashi->render ( '/Contact/index.html.twig', $this->data );
	}
	function submit($params = array()) {
		$mail = $this->atashi->getPost ( 'mail', "unknown" );
		$text = $this->atashi->getPost ( 'text', "" );
		$ip = $this->atashi->getServer ( 'REMOTE_ADDR', "unknown" );
		
		if ($text != "") {
			//Process message
			$this->atashi->setSession ( 'sended', true );
		} else {
			$this->atashi->setSession ( 'mail', $mail );
			$this->atashi->setSession ( 'text', $text );
			$this->atashi->setSession ( 'sended', false );
		}
		
		$this->atashi->redirect ( "/contact/" );
	}
}
