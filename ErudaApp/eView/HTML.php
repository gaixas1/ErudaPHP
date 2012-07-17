<?php
/**
 * Description of eView => HTML
 * Eruda HTML response document View
 *
 * @author gaixas1
 */
class eView_HTML extends eView{
    protected $layout;
    protected $frames;
    protected $header;
    
    function __construct($layout, $frames=array()) {
        $this->layout = $layout;
        $this->frames = $frames;
    }

    function setHeader($header){
        $this->header = $header;
        return $this;
    }
    
    function getHeader(){
        return $this->header;
    }
    
    public function show($model) {
        $folders = eCore::getFolders();
        $this->header->printDOCTYPE();
?>
<html>
<?php 
        $this->header->printHeader($folders);
?>
<?php 
        include(APP_PATH.'layouts/'.$this->layout.'.php');
?>
</html>
<?php
    }
    
    public function showframe($frame, $model) {
        $folders = eCore::getFolders();
        include(APP_PATH.'layouts/'.$this->layout.'/'.$this->frames[$frame].'.php');
    }
}
?>