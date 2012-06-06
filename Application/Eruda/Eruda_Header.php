<?php
/**
 * Description of Eruda_Header
 *
 * @author gaixas1
 */

/**
 * @property string $_type  
 * @property array(string) $_avaliveTypes 
 */
abstract class Eruda_Header {
    protected $_avaliveTypes = array();
    protected $_type;
    
    /**
     * @param string $type 
     */
    function __construct(){}
    
    /**
     * @param string $type
     * @return boolean  
     */
    function validType($type) {
        return in_array($type, $this->_avaliveTypes);
    }
    
    /**
     *
     * @param string $type
     * @throws Exception 
     */
    function setType($type) {
        if($this->validType($type)) {
            $this->_type = $type;
        } else {
            throw new Exception('Eruda_Header::setType - INVALID DOCTYPE : '.$type);
        }
    }
    
    abstract function printDOCTYPE();
    abstract function printHeader($folders = array());
}
?>
