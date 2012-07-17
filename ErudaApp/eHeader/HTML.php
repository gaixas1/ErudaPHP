<?php
/**
 * Description of eHeader => HTML
 * Eruda HTML response document Header
 *
 * @author gaixas1
 */
class eHeader_HTML extends eHeader {
    private $_title = array();
    private $_titleSep = ' - ';
    
    private $_cType = 'UTF-8';
    private $_base = '/';
    private $_target = '_self';
    private $_keys = array();
    private $_meta = array();
    
    private $_avaliveRSSTypes = array();
    private $_rss = array();
    
    private $_css = array();
    private $_js = array();
    
    private $_cssExt = array();
    private $_jsExt = array();
    
    function __construct(){
        $this->_avaliveTypes = array(
            'HTML4 Strict',
            'HTML4 Transitional',
            'HTML4 Frameset',
            'XHTML1 Strict',
            'XHTML1 Transitional',
            'XHTML1 Frameset',
            'HTML5'
        );
        $this->_avaliveRSSTypes = array(
            'RSS',
            'RSS2',
            'ATOM'
        );
        $this->_cType = 'UTF-8';
        $this->setType('HTML5');
        
    }

    public function printDOCTYPE() {
        switch($this->_type){
            case 'HTML4 Strict':?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><?php break;
            case 'HTML4 Transitional':?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><?php break;
            case 'HTML4 Frameset':?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd"><?php break;
            case 'XHTML1 Strict':?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><?php break;
            case 'XHTML1 Transitional':?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><?php break;
            case 'XHTML1 Frameset':?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"><?php break;
            case 'HTML5':?><!DOCTYPE html><?php break;
        }
    }
    
    public function printHeader($folders = array()) {
?>
<head>
    <?php if(!empty($this->_title)) { ?><title><?php echo $this->getTitle(); ?></title><?php }?>
    
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_cType; ?>" />
    
    <base href="<?php echo $this->_base; ?>" target="<?php echo $this->_target; ?>"/>
    
<?php if(!empty($this->_keys)) { ?>
    <meta name="keywords" content="<?php echo implode(',', $this->_keys);?>"><?php }?>
    
<?php foreach($this->_meta as $name => $value) { ?>
    <meta name="<?php echo $name;?>" content="<?php echo $value;?>">
<?php }?>
    
<?php if(isset($folders['css'])) { 
        foreach($this->_css as $value) { ?>
    <link href="<?php echo $folders['css'].$value;?>" rel="stylesheet" type="text/css">
<?php } }?>
<?php  foreach($this->_cssExt as $value) { ?>
    <link href="<?php echo $value;?>" rel="stylesheet" type="text/css">
<?php }?>
    
<?php if(isset($folders['js'])) { 
        foreach($this->_js as $value) { ?>
    <script type="text/javascript" src="<?php echo $folders['js'].$value;?>"></script>
<?php } }?>
<?php  foreach($this->_jsExt as $value) { ?>
    <script type="text/javascript" src="<?php echo $value;?>"></script>
<?php }?>
    
<?php if(isset($this->_rss['RSS'])) { ?>
    <link rel="alternate" type="text/xml" title="RSS .92" href="<?php echo $this->_rss['RSS'];?>" />
<?php }?>
<?php if(isset($this->_rss['RSS2'])) { ?>
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo $this->_rss['RSS2'];?>" />
<?php }?>
<?php if(isset($this->_rss['ATOM'])) { ?>
    <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php echo $this->_rss['ATOM'];?>" />
<?php }?>
    
</head>
<?php
    }
    
    
    function resetTitle(){
        $this->_title = array();
        return $this;
    }
    
    
    function append2Title($item) {
        $this->_title[] = $item;
        return $this;
    }
    
    
    function prepend2Title($item) {
        array_unshift($this->_title,$item);
        return $this;
    }
    
    
    function setTitleSeparator($sep) {
        $this->_titleSep = $sep;
        return $this;
    }
    
    
    function getTitle() {
        return implode($this->_titleSep, $this->_title);
    }
    
    
    function resetKeywords(){
        $this->_keys = array();
        return $this;
    }
    
    
    function addKeyword($key) {
        $key = str_replace('"', "\"", $key);
        $key = strtolower($key);
        if(!in_array($key, $this->_keys)) {
            $this->_keys[] = $key;
        }
        return $this;
    }
    
    
    function addRSS($dir,$type = 'RSS2') {
        $this->_rss[$type] = $dir;
        return $this;
    }
    
    
    function resetMeta(){
        $this->_keys = array();
        return $this;
    }
    
    
    function setMetatag($name, $value) {
        $value = str_replace('"', "\"", $value);
        $name = strtolower($name);
        $this->_meta[$name] = $value;
        return $this;
    }
    
    
    function setContentType($type) {
        $type = strtolower($type);
        $this->_cType = $type;
        return $this;
    }
    
    
    function setBaseURL($base) {
        $this->_base = $base;
        return $this;
    }
    
    
    function setDefaultTarget($target) {
        $this->_target = $target;
        return $this;
    }
    
    
    function resetCSS(){
        $this->_css = array();
        return $this;
    }
    
    
    function addCSS($file) {
        $file = str_replace('"', "'", $file); 
        if(!in_array($file, $this->_css)) {
            $this->_css[] = $file;
        }
        return $this;
    }
    
    
    function resetJavascript(){
        $this->_js = array();
        return $this;
    }
    
    
    function addJavascript($file) {
        $file = str_replace('"', "'", $file);
        if(!in_array($file, $this->_js)) {
            $this->_js[] = $file;
        }
        
        return $this;
    }
    
    
    function resetExternCSS(){
        $this->_cssExt = array();
        return $this;
    }
    
    
    function addExternCSS($file) {
        $file = str_replace('"', "'", $file);
        if(!in_array($file, $this->_cssExt)) {
            $this->_cssExt[] = $file;
        }
        return $this;
    }
    
    
    function resetExternJavascript(){
        $this->_jsExt = array();
        return $this;
    }
    
    
    function addExternJavascript($file) {
        $file = str_replace('"', "'", $file);
        if(!in_array($file, $this->_jsExt)) {
            $this->_jsExt[] = $file;
        }
        return $this;
    }
}
?>