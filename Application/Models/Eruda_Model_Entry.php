<?php
/**
 * Description of Eruda_Model_Entry
 *
 * @author gaixas1
 */

/**
 * @property Eruda_Model_User $author 
 */
class Eruda_Model_Entry extends Eruda_Model implements Eruda_Interface_rssItem, Eruda_Interface_sitemapItem {
    protected $id;
    protected $title;
    protected $text;
    protected $comments;
    
    protected $created;
    protected $lastmod;
    
    protected $author_id;
    protected $author;
    
    protected $cats_id = array();
    protected $cats = array();
    
    //
    //protected $tags = array();
    
    function set_id($id){
        $this->id = $id;
        return $this;
    }
    function get_id(){
        return $this->id;
    }
    
    
    function set_title($title){
        $this->title = $title;
        return $this;
    }
    function get_title(){
        return $this->title;
    }
    
    function set_text($text){
        $this->text = $text;
        return $this;
    }
    function get_text(){
        return $this->text;
    }
    
    function set_author_id($author_id){
        $this->author_id = $author_id;
        return $this;
    }
    function get_author_id(){
        return $this->author_id;
    }
    
    function set_author($author){
        $this->author = $author;
        return $this;
    }
    /**
     * @return Eruda_Model_User 
     */
    function get_author(){
        return $this->author;
    }
    
    
    function set_cats_id($cats_id){
        $this->cats_id = $cats_id;
        return $this;
    }
    function get_cats_id(){
        return $this->cats_id;
    }
    
    function set_cats($cats){
        $this->cats = $cats;
        return $this;
    }
    function get_cats(){
        return $this->cats;
    }
    
    function set_comments($comments){
        $this->comments = $comments;
        return $this;
    }
    function get_comments(){
        return $this->comments;
    }
    /*
    function set_tags($tags){
        $this->tags = $tags;
        return $this;
    }
    function get_tags(){
        return $this->tags;
    }
    */
    function set_created($created){
        $this->created = $created;
        return $this;
    }
    function get_created(){
        return $this->created;
    }
    
    function set_lastmod($lastmod){
        $this->lastmod = $lastmod;
        return $this;
    }
    function get_lastmod(){
        return $this->lastmod;
    }
    

    public function __toString() {
        return 'Eruda_Model_Entry('.$this->id.')::'.$this->title;
    }

    
    public function rss_get_pubDate() {
        return $this->created;
    }

    public function rss_get_author() {
        return $this->author->get_name();
        
    }

    public function rss_get_categories() {
        $ret = array();
        foreach ($this->cats as $cat) {
            $ret[] = $cat->get_name();
        }
        return $ret;
    }

    public function rss_get_comments() {
        return Eruda::getEnvironment()->getBaseURL().$this->id.'/'.Eruda_Helper_Parser::Text2Link($this->title).'/#comentar';
    }

    public function rss_get_description() {
        return $this->text;
    }


    public function rss_get_guid() {
        return Eruda::getEnvironment()->getBaseURL().$this->id.'/'.Eruda_Helper_Parser::Text2Link($this->title).'/#comentar';
    }

    public function rss_get_link() {
        return Eruda::getEnvironment()->getBaseURL().$this->id.'/'.Eruda_Helper_Parser::Text2Link($this->title).'/';
    }

    public function rss_get_source() {}

    public function rss_get_title() {
        return $this->title;
    }

    public function rss_has_author() {
        return true;
    }

    public function rss_has_comments() {
        return true;
    }


    public function rss_has_guid() {
        return true;
    } 
    
    public function rss_has_pubDate() {
        return true;
    }

    public function rss_has_source() {
        return false;
    }

    public function sitemap_get_changefreg() {
        return 'never';
    }

    public function sitemap_get_lastmod() {
        return $this->lastmod;
    }

    public function sitemap_get_loc() {
        return Eruda::getEnvironment()->getBaseURL().$this->id.'/'.Eruda_Helper_Parser::Text2Link($this->title).'/';
    }

    public function sitemap_get_priority() {
        return '0.9';
    }

    public function sitemap_has_lastmod() {
        return true;
    }
}

?>