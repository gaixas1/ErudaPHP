<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_View_HTML
 *
 * @author gaixas1
 */
class Eruda_View_HTML extends Eruda_View{
    protected $layout;
    protected $frames;
    protected $_header;
    
    function __construct($layout, $frames=array()) {
        $this->layout = $layout;
        $this->frames = $frames;
    }

    
    
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

    
    public function show($model) {
        $folders = Eruda::getFolders();
        $this->_header->printDOCTYPE();
?>
<html>
<?php 
        $this->_header->printHeader($folders);
?>
<?php 
        include('Layouts/'.$this->layout.'.php');
?>
</html>
<?php
    }
    
    public function showframe($frame, $model) {
        $folders = Eruda::getFolders();
        include('Layouts/'.$this->layout.'/'.$this->frames[$frame].'.php');
    }
}

?>
