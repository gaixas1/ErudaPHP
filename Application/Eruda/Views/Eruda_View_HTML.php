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
    
    function __construct($layout, $frames=array()) {
        $this->layout = $layout;
        $this->frames = $frames;
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
