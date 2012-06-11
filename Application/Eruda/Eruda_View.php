<?php
/**
 * Description of Eruda_View
 *
 * @author gaixas1
 */

/**
 * @property Eruda_Header $_header 
 */
abstract class Eruda_View {
    protected $_header;
    
    /**
     * @param Eruda_Header $header
     * @return \Eruda_View
     * @throws Exception 
     */
    function setHeader($header){
        if($header!=null && $header instanceof Eruda_Header)
            $this->_header = $header;
        else
            throw new Exception('Eruda_View::setHeader - BAD HEADER : '.$header);
        return $this;
    }
    
    /**
     * @return \Eruda_Header_HTML 
     */
    function getHeader(){
        return $this->_header;
    }
    
    /**
     * @param Eruda_Model $model
     */
    abstract function show($folders, $model);
}

?>
