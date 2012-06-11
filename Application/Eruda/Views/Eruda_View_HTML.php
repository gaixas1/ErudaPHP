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
    
    function __construct($layout) {
        $this->layout = $layout;
    }


    
    public function show($folders, $model) {
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
}

?>
