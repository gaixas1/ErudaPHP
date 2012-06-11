<?php

/**
 * Description of Eruda_Controller
 *
 * @author gaixas1
 */
abstract class Eruda_Controller {
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
