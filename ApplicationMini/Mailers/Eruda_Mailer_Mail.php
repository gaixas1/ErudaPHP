<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Mailer_Mail
 *
 * @author gaixas1
 */
class Eruda_Mailer_Mail extends Eruda_Mailer{
    public function send($to, $subject, $message) {
        
    $cabeceras = 'From: '.$this->from . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        mail ($to, $subject, $message, $cabeceras );
    }
}

?>
