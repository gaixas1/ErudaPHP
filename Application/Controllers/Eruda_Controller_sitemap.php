<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Controller_rss
 *
 * @author gaixas1
 */
class Eruda_Controller_sitemap {
    
    public function ini() {
        Eruda::getDBConnector()->connect();
    }
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    
    function index() {        
        if(!$this->_onlyheader) {
            $entries = Eruda_Mapper_Entry::All();
            $cats = Eruda_Mapper_Category::All();
            $proy = Eruda_Mapper_Proyecto::All();
            
            $model = new Eruda_Model_sitemap();
            $model->add_item(new Eruda_Model_SitemapItem(
                    Eruda::getEnvironment()->getBaseURL(),
                    'weekly',
                    1
                    ));
            $model->add_items($entries);
            $model->add_items($cats);
            $model->add_items($proy);
            
            $view = new Eruda_View_sitemap();
            return new Eruda_MV($view, $model);
        }
        return null;
    }
}

?>
