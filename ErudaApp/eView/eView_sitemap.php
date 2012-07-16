<?php
/**
 * Description of eView => Sitemap
 * Eruda Sitemap response view
 *
 * @author gaixas1
 */
class eView_sitemap extends eView {
    public function show($model) {
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.90">
<?php
        foreach($model->get_items() as $item) {
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