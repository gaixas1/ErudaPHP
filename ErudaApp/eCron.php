<?php
/**
 * Description of eCron
 * Eruda Cron Controller
 * AppClass for con jobs
 *
 * @author gaixas1
 */
class eCron {
    private $file;
    
    public function __construct() {
        $this->file = PATH.'\log.txt';
    }

    public function log($txt){
        file_put_contents($this->file, date(DATE_ATOM).' - '. $txt.'
', FILE_APPEND );
    }
    
    public function ini(){}
    public function end(){}
    
    public function Index(){}
}
?>