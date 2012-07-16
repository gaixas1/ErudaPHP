<?php
/**
 * Description of eMV
 * Eruda Model and View
 * Contains all needed data for display the result page
 *
 * @author gaixas1
 */
class eMV {
    protected $model;
    protected $view;
    
    function __construct($view=null, $model=null) {
        if($view!=null)
            $this->setView ($view);
        if($model!=null)
            $this->setModel ($model);
    }
    
    function show(){
        $this->view->show($this->model);
    }
    
/**
* * Getters & Setters
**/
    
    function getModel(){
        return $this->model;
    }
    function setModel($model){
        $this->model = $model;
        return $this;
    }
    
    function getView(){
        return $this->$view;
    }
    function setView($view){
        $this->view = $view;
        return $this;
    }
}
?>