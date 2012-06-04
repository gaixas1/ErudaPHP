<?php
/**
 * Description of Eruda_Header_HTML
 *
 * @author gaixas1
 */

/**
 * @property array(string) $_title 
 * @property string $_titleSep 
 * @property string $_cType 
 * @property string $_base 
 * @property string $_target 
 * @property array(string) $_keys 
 * @property array(string) $_meta 
 * @property array(string) $_css 
 * @property array(string) $_js 
 * @property array(string) $_cssExt 
 * @property array(string) $_jsExt 
 */
class Eruda_Header_HTML extends Eruda_Header {
    
    private $_title = array();
    private $_titleSep = ' - ';
    
    private $_cType = 'utf-8';
    private $_base = '/';
    private $_target = '_self';
    private $_keys = array();
    private $_meta = array();
    
    
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
        $this->_cType = 'utf-8';
        
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
    
    <?php if(!empty($this->_keys)) { ?><meta name="keywords" content="<?php echo implode(',', $this->_keys);?>"><?php }?>
    
    <?php foreach($this->_meta as $name => $value) { ?><meta name="<?php echo $name;?>" content="<?php echo $value;?>">
    <?php }?>
    
    <?php if(isset($folders['css'])) { 
        foreach($this->_css as $value) { ?><link href="<?php echo $folders['css'].$value;?>" rel="stylesheet" type="text/css">
    <?php }
    }?>
    <?php  foreach($this->_cssExt as $value) { ?><link href="<?php echo $value;?>" rel="stylesheet" type="text/css">
    <?php }?>
    
    <?php if(isset($folders['js'])) { 
        foreach($this->_js as $value) { ?><script type="text/javascript" src="<?php echo $folders['js'].$value;?>"></script>
    <?php }
    }?>
    <?php  foreach($this->_jsExt as $value) { ?><script type="text/javascript" src="<?php echo $value;?>"></script>
    <?php }?>
    
</head>
<?php
    }
    
    /**
     * @return \Eruda_Header_HTML 
     */
    function resetTitle(){
        $this->_title = array();
        return $this;
    }
    
    /**
     * @param string $item
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function append2Title($item) {
        if($item!=null && is_string($item)){
            $this->_title[] = $item;
        } else {
            throw new Exception('Eruda_Header_HTML::append2Title - INVALID VALUE : '.$item);
        }
        return $this;
    }
    
    /**
     * @param string $item
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function prepend2Title($item) {
        if($item!=null && is_string($item)){
            array_unshift($this->_title,$item);
        } else {
            throw new Exception('Eruda_Header_HTML::prepend2Title - INVALID VALUE : '.$item);
        }
        return $this;
    }
    
    /**
     *
     * @param string $sep
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function setTitleSeparator($sep) {
        if($sep!=null && is_string($sep)){
            $this->_titleSep = $sep;
        } else {
            throw new Exception('Eruda_Header_HTML::prepend2Title - INVALID VALUE : '.$sep);
        }
        return $this;
    }
    
    /**
     * @return string 
     */
    function getTitle() {
        return implode($this->_titleSep, $this->_title);
    }
    
    
    /**
     * @return \Eruda_Header_HTML 
     */
    function resetKeywords(){
        $this->_keys = array();
        return $this;
    }
    
    /**
     * @param string $key
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function addKeyword($key) {
        if($key!=null && is_string($key) && strlen($key)>0) {
            $key = str_replace('"', "\"", $key);
            $key = strtolower($key);
            if(!in_array($key, $this->_keys)) {
                $this->_keys[] = $key;
            }
        } else {
            throw new Exception('Eruda_Header_HTML::addKeyword - INVALID VALUE : '.$key);
        }
        return $this;
    }
    
    
    
    
    /**
     * @return \Eruda_Header_HTML 
     */
    function resetMeta(){
        $this->_keys = array();
        return $this;
    }
    
    /**
     * @param string $name
     * @param string $value
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function setMetatag($name, $value) {
        if($name!=null && is_string($name) && strlen($name)>0) {
            if($value!=null && is_string($value) && strlen($value)>0) {
                $value = str_replace('"', "\"", $value);
                $name = strtolower($name);
                $this->_meta[$name] = $value;
            } else {
                throw new Exception('Eruda_Header_HTML::setMetatag - INVALID VALUE : '.$value);
            }
        } else {
            throw new Exception('Eruda_Header_HTML::setMetatag - INVALID TAG : '.$name);
        }
        return $this;
    }
    
    /**
     * @param string $type
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function setContentType($type) {
        if($type!=null && is_string($type) && strlen($type)>0) {
            $type = strtolower($type);
            $this->_cType = $type;
        } else {
            throw new Exception('Eruda_Header_HTML::setContentType - INVALID TYPE : '.$type);
        }
        return $this;
    }
    
    /**
     * @param string $type
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function setBaseURL($base) {
        if($base!=null && is_string($base) && strlen($base)>0) {
            $this->_base = $base;
        } else {
            throw new Exception('Eruda_Header_HTML::setBaseURL - INVALID URL : '.$base);
        }
        return $this;
    }
    
    /**
     * @param string $type
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function setDefaultTarget($target) {
        if($target!=null && is_string($target) && strlen($target)>0) {
            $this->_target = $target;
        } else {
            throw new Exception('Eruda_Header_HTML::setDefaultTarget - INVALID TARGET : '.$target);
        }
        return $this;
    }
    
    /**
     * @return \Eruda_Header_HTML 
     */
    function resetCSS(){
        $this->_css = array();
        return $this;
    }
    
    /**
     * @param string $file
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function addCSS($file) {
        if($file!=null && is_string($file) && strlen($file)>0) {
            $file = str_replace('"', "'", $file); 
            if(!in_array($file, $this->_css)) {
                $this->_css[] = $file;
            }
        } else {
            throw new Exception('Eruda_Header_HTML::addCSS - INVALID FILE : '.$file);
        }
        return $this;
    }
    
    /**
     * @return \Eruda_Header_HTML 
     */
    function resetJavascript(){
        $this->_js = array();
        return $this;
    }
    
    /**
     * @param string $file
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function addJavascript($file) {
        if($file!=null && is_string($file) && strlen($file)>0) {
            $file = str_replace('"', "'", $file);
            if(!in_array($file, $this->_js)) {
                $this->_js[] = $file;
            }
        } else {
            throw new Exception('Eruda_Header_HTML::addJavascript - INVALID FILE : '.$file);
        }
        return $this;
    }
    
    
    
    /**
     * @return \Eruda_Header_HTML 
     */
    function resetExternCSS(){
        $this->_cssExt = array();
        return $this;
    }
    
    /**
     * @param string $file
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function addExternCSS($file) {
        if($file!=null && is_string($file) && strlen($file)>0) {
            $file = str_replace('"', "'", $file);
            if(!in_array($file, $this->_cssExt)) {
                $this->_cssExt[] = $file;
            }
        } else {
            throw new Exception('Eruda_Header_HTML::addExternCSS - INVALID FILE : '.$file);
        }
        return $this;
    }
    
    /**
     * @return \Eruda_Header_HTML 
     */
    function resetExternJavascript(){
        $this->_jsExt = array();
        return $this;
    }
    
    /**
     * @param string $file
     * @return \Eruda_Header_HTML
     * @throws Exception 
     */
    function addExternJavascript($file) {
        if($file!=null && is_string($file) && strlen($file)>0) {
            $file = str_replace('"', "'", $file);
            if(!in_array($file, $this->_jsExt)) {
                $this->_jsExt[] = $file;
            }
        } else {
            throw new Exception('Eruda_Header_HTML::addExternJavascript - INVALID FILE : '.$file);
        }
        return $this;
    }
}

?>
