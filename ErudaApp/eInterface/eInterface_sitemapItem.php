<?php
interface eInterface_sitemapItem
{
    function sitemap_get_loc();
    function sitemap_get_changefreg();
    function sitemap_get_priority();
    function sitemap_has_lastmod();
    function sitemap_get_lastmod();
}
?>