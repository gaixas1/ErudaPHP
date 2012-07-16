<?php
/**
 * Description of eHeader
 * Eruda response document Header
 * ABSTRACT CLASS
 *
 * @author gaixas1
 */
abstract class eHeader {
    protected $_avaliveTypes = array();
    protected $_type;
    
    function __construct(){}
    
    function validType($type) {
        return in_array($type, $this->_avaliveTypes);
    }
    function setType($type) {
        $this->_type = $type;
    }
    
    abstract function printDOCTYPE();
    abstract function printHeader($folders = array());
}
?>