<?php

/**
 * Description of Eruda_View_RSS2
 *
 * @author gaixas1
 */

class Eruda_View_sitemap extends Eruda_View {
    
    /**
     * @param Eruda_Model_sitemap $model 
     */
    public function show($model) {
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.90">
<?php
//var_dump($model);
        foreach($model->get_items() as $item) {
/**
 *@var Eruda_Interface_sitemapItem $item 
 */
?>
        <url> 
            <loc><?php echo ($item->sitemap_get_loc());?></loc> 
            <?php if($item->sitemap_has_lastmod()){?><lastmod><?php echo date('Y-m-dTH:i:s+01:00',strtotime($item->sitemap_get_lastmod()));?></lastmod> <?php }?>
            <changefreg><?php echo ($item->sitemap_get_changefreg());?></changefreg> 
            <priority><?php echo ($item->sitemap_get_priority());?></priority> 
        </url>
<?php
        }
?>
</urlset>
<?php
    }
}
?>
