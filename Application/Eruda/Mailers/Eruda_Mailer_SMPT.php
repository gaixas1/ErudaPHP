<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Mailer_SMPT
 *
 * @author gaixas1
 */
class Eruda_Mailer_SMPT extends Eruda_Mailer{
    protected $fromName;
    protected $host;
    protected $username;
    protected $password;
    
    
    public function __construct($from, $fromName, $host, $username,$password) {
        $this->from = $from;
        $this->fromName = $fromName;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }
    
    public function send($to, $subject, $message) {
        $mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
        $mail->IsHTML(true);
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = $this->host;
	$mail->Port = 465; 
	$mail->Username = $this->username;  
	$mail->Password = $this->password;           
	$mail->SetFrom($this->from, $this->fromName);
	//$mail->Subject = utf8_decode($subject);
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
    }
}

?>
