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
class Eruda_View_partHTML extends Eruda_View_HTML{
    public function show($model) {
        $folders = Eruda::getFolders();
        include('Layouts/'.$this->layout.'.php');
    }
}

?>
