<?php
/**
 * Description of eController
 * Eruda Controller
 * ABSTRACT CLASS
 *
 * @author gaixas1
 */
abstract class eController {
    protected $_onlyheader;
    protected $_params;
    
    function __construct($params, $onlyheader=false){
        if(is_array($params))
            $this->_params = $params;
        
        if($onlyheader)
            $this->_onlyheader=true;
        else
            $this->_onlyheader = false;
    }
    
    abstract function ini();
    abstract function end();
}
?>