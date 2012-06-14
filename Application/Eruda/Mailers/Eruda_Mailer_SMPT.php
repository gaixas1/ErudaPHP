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
    public function send($to, $subject, $message) {
        
        $mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = 'gaixas1@gmail.com';  
	$mail->Password = 'sergio@1255';           
	$mail->SetFrom('gaixas1@gmail.com', 'gaixas1');
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
        
        
        
        
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = 'gaixas1@gmail.com';//$this->from;
        $mail->Password = "sergio@1255";
        
        $mail->From = 'gaixas1@gmail.com';//$this->from;
        
        $mail->FromName = "gaixas1";
        $mail->Subject = $subject;
        $mail->AltBody = $message;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
        $mail->IsHTML(true);

        if(!$mail->Send()) {
            echo "Error: " . $mail->ErrorInfo;
        } else {
                echo "Mensaje enviado correctamente";
        }
    }
}

?>
