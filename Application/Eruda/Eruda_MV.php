<?php

/**
 * Description of Eruda_MV
 *
 * @author gaixas1
 */

/**
 * @property Eruda_Model $_model;
 * @property Eruda_View $_view; 
 */
class Eruda_MV {
    protected $_model;
    protected $_view;
    
    /**
     * @param Eruda_View $view
     * @param Eruda_Model $model 
     */
    function __construct($view=null, $model=null) {
        if($view!=null)
            $this->setView ($view);
        if($model!=null)
            $this->setModel ($model);
    }
    
    /**
     * @return \Eruda_Model 
     */
    function getModel(){
        return $this->_model;
    }
    
    /**
     * @param Eruda_Model $model
     * @return \Eruda_MV
     * @throws Exception 
     */
    function setModel($model){
        if($model!=null && $model instanceof Eruda_Model)
            $this->_model = $model;
        else
            throw new Exception('Eruda_MV::setModel - BAD MODEL : '.$model);
        return $this;
    }
    
    
    /**
     * @return \Eruda_View 
     */
    function getView(){
        return $this->$_view;
    }
    
    /**
     * @param Eruda_View $view
     * @return \Eruda_MV
     * @throws Exception 
     */
    function setView($view){
        if($view!=null && $view instanceof Eruda_View)
            $this->_view = $view;
        else
            throw new Exception('Eruda_MV::setView - BAD MODEL : '.$view);
        return $this;
    }
    
    
    function show(){
        $this->_view->show($this->_model);
    }
}

?>
