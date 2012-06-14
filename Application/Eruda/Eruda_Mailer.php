<?php
/**
 * Description of Eruda_Mailer
 *
 * @author gaixas1
 */
abstract class Eruda_Mailer {
    protected $from;
    
    function __construct($from) {
        $this->from = $from;
    }
    
    abstract function send($to, $subject, $message);
}

?>
