<?php
/**
 * Description of eMailer
 * Eruda Mailer
 * ABSTRACT CLASS
 *
 * @author gaixas1
 */
abstract class eMailer {
    protected $from;
    function __construct($from) {
        $this->from = $from;
    }
    abstract function send($to, $subject, $message);
}
?>