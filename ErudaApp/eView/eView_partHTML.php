<?php
/**
 * Description of eView => HTML => Partial
 * Eruda HTML partial response document View
 *
 * @author gaixas1
 */
class eView_partHTML extends eView_HTML{
    public function show($model) {
        $folders = eCore::getFolders();
        include('Layouts/'.$this->layout.'.php');
    }
}
?>