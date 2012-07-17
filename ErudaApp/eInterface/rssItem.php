<?php
interface eInterface_rssItem
{
    function rss_get_title();
    function rss_get_link();
    function rss_get_description();
    
    function rss_has_author();
    function rss_get_author();
    
    function rss_get_categories();
    
    function rss_has_comments();
    function rss_get_comments();
    
    function rss_has_guid();
    function rss_get_guid();
    
    function rss_has_pubDate();
    function rss_get_pubDate();
    
    function rss_has_source();
    function rss_get_source();
}
?>