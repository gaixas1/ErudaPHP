<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eruda_Model_SitemapItem
 *
 * @author gaixas1
 */
class Eruda_Model_SitemapItem extends Eruda_Model implements Eruda_Interface_sitemapItem {
    protected $loc;
    protected $changefreg;
    protected $lastmod;
    protected $priority;
    
    public function __construct($loc, $changefreg = 'never', $priority = '0.5', $lastmod = null) {
        $this->loc = $loc;
        $this->changefreg = $changefreg;
        $this->priority = $priority;
        $this->lastmod = $lastmod;
    }
    
    public function __toString() {
        return 'Eruda_Model_SitemapItem';
    }
    public function sitemap_get_changefreg() {
        return $this->changefreg;
    }
    public function sitemap_get_lastmod() {
        return $this->lastmod;
        
    }
    public function sitemap_get_loc() {
        return $this->loc;
        
    }
    public function sitemap_get_priority() {
        return $this->priority;
        
    }
    public function sitemap_has_lastmod() {
        return $this->lastmod!=null;
    }
}

?>
