<?php

/**
 * Description of Eruda_View_RSS2
 *
 * @author gaixas1
 */

class Eruda_View_RSS2 extends Eruda_View {
    
    /**
     * @param Eruda_Model_RSS $model 
     */
    public function show($model) {
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<rss version="2.0">
    <channel>
        <title><?php echo $model->get_title();?></title>
        <link><?php echo $model->get_link();?></link>
        <language><?php echo $model->get_language();?></language> 
        <description><?php echo $model->get_description();?></description> 
        <generator><?php echo $model->get_generator();?></generator> 
<?php
        foreach($model->get_items() as $item) {
/**
 *@var Eruda_Interface_rssItem $item 
 */
?>
        <item> 
            <title><?php echo ($item->rss_get_title());?></title> 
            <link><?php echo $item->rss_get_link();?></link> 
            <description><![CDATA[<?php echo $item->rss_get_description();?>]]></description> 
<?php if($item->rss_has_author()){?>
            
            <author><?php echo $item->rss_get_author();?></author> <?php }?>
<?php foreach($item->rss_get_categories() as $cat){?>
            
            <category><?php echo $cat;?></category> <?php }?>
<?php if($item->rss_has_comments()){?>
            
            <comments><?php echo $item->rss_get_comments();?></comments> <?php }?>
<?php if($item->rss_has_guid()){?>
            
            <guid><?php echo $item->rss_get_guid();?></guid> <?php }?>
<?php if($item->rss_has_pubDate()){?>
            
            <pubDate><?php echo  gmdate(DATE_RSS, strtotime($item->rss_get_pubDate()));?></pubDate> <?php }?>
<?php if($item->rss_has_source()){
    $s = $item->rss_get_guid();?>
            
            <source url="<?php echo $s[0];?>"><?php echo $s[1];?></source> <?php }?>
            
        </item>
<?php
        }
?>
    </channel>
</rss>
<?php
    }
}
?>
