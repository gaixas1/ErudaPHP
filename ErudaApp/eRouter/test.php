<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eRouter_test
 *
 * @author gaixas1
 */
class eRouter_test extends eRouter{
    
    function parsematches(&$params,&$matches){
        array_shift($matches);
        $params[$matches[0]] = $matches[1];
    }
    
}

?>
