<?php

namespace Atashi;

// Vendor Require
require_once dirname ( __FILE__ ) . '/../extern/swiftmailer/swift_required.php';
class Mailer {
	private $mailer;
	public $server;
	public $port;
	public $username;
	public $pass;
	public $sender;
	public $senderName;
	function __construct($server, $port, $username, $pass, $sender, $senderName) {
		$this->server = $server;
		$this->port = $port;
		$this->username = $username;
		$this->pass = $pass;
		$this->sender = $sender;
		$this->senderName = $senderName;
		$this->mailer = null;
	}
	function sendMail($title, $to, $msg_txt, $msg_html) {
		if ($this->mailer == null) {
			$this->mailer = \Swift_Mailer::newInstance ( \Swift_MailTransport::newInstance () );
		}
		if ($to == null) {
			$to = $this->sender;
		}
		
		$message = \Swift_Message::newInstance ();
		$message->setSubject ( $title );
		$message->setFrom ( array (
				$this->sender => $this->senderName 
		) );
		$message->setTo ( array (
				$to 
		) );
		$message->setBody ( $msg_txt, 'text/plain' );
		$message->addPart ( $msg_html, 'text/html' );
		$message->setCharset ( 'utf-8' );
		$this->mailer->send ( $message );
	}
}
