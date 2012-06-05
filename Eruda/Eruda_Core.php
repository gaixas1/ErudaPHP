<?php
/**
 * Description of Eruda_Core
 *
 * @author gaixas1
 */
/**
 * @property string $_uri
 * @property string $_base
 * @property string $_method
 * @property Eruda_Router $_router
 * @property Eruda_CF $_cf
 * @property array $_params
 * @property array(string) $_folders
 */
class Eruda_Core {
    protected $_uri;
    protected $_base;
    protected $_method;
    protected $_router;
    protected $_cf;
    protected $_params;
    
    protected $_folders = array();
    
    /**
     * @param Eruda_Router $router 
     */
    function __construct(){
        $this->_router = null;
        $this->_base = '';
        $this->setUri($_SERVER['REQUEST_URI']);
        $this->setMethod($_SERVER['REQUEST_METHOD']);
        
        $this->_cf = null;
        $this->_params = array();
    }
    
    
    public function __toString() {
        $ret = '<h3>Eruda_Core</h3>';
        $ret .= '<table>';
        $ret .= '<tr><td>Uri</td><td>'.$this->_uri.'</td></tr>';
        $ret .= '<tr><td>Base</td><td>'.$this->_base.'</td></tr>';
        $ret .= '<tr><td>Method</td><td>'.$this->_method.'</td></tr>';
        $ret .= '<tr><td>CF</td><td>'.$this->_cf.'</td></tr>';
        $ret .= '<tr><td>Params</td><td>'.print_r($this->_params, true).'</td></tr>';
        $ret .= '</table>';
        
        return $ret;
    }
    
    /** 
     * @return \Eruda_Core 
     */
    function parseUri() {
        if($this->_router!=null) {
            $uri = preg_replace('~'.$this->_base.'~', '', $this->_uri, 1);
            if($uri[0]=='/') $uri = substr($uri, 1);
            $this->setCF($this->_router->run($uri, $this->_method, $this->_params));
        }
        
        return $this;
    }
    
    /**
     * @param Eruda_Router $router
     * @return \Eruda_Core
     * @throws Exception 
     */
    function setRouter($router) {
        if($router!= null && $router instanceof Eruda_Router) {
            $this->_router = $router;
        } else {
            throw new Exception('Eruda_Core::run - NOT VALID ROUTER');
        }
        return $this;
    }
    
    /**
     * @return Eruda_Router 
     */
    function getRouter(){
        return $this->_router;
    }
    
    /**
     * @param string $base
     * @return \Eruda_Core
     * @throws Exception 
     */
    function setBase($base) {
        if($base!= null && is_string($base)) {
            $this->_base = $base;
        } else {
            throw new Exception('Eruda_Core::setBase - NOT VALID BASE');
        }
        return $this;
    }
    
    /**
     * @return string 
     */
    function getBase() {
        return $this->_base;
    }
    
    
    /**
     *
     * @param string $uri
     * @return \Eruda_Core
     * @throws Exception 
     */
    function setUri($uri) {
        if($uri!= null && is_string($uri)) {
            $this->_uri = $uri;
        } else {
            throw new Exception('Eruda_Core::setUri - NOT URI');
        }
        return $this;
    }
    
    /**
     * @return string 
     */
    function getUri() {
        return $this->_uri;
    }
    
    /**
     *
     * @param string $method
     * @return \Eruda_Core
     * @throws Exception 
     */
    function setMethod($method) {
        if($method!= null && is_string($method) && in_array($method, Eruda_CF::$_methods)) {
            $this->_method = $method;
        } else {
            throw new Exception('Eruda_Core::setMethod - Bad Method');
        }
        return $this;
    }
    
    /**
     * @return string 
     */
    function getMethod() {
        return $this->_method;
    }
    
    /**
     * @param Eruda_CF $cf
     * @throws Exception 
     * @return Eruda_Core
     */
    function setCF($cf) {
        if($cf!=null && $cf instanceof Eruda_CF) {
            $this->_cf = $cf;
        } else {
            throw new Exception('Eruda_Core::setCF - Bad CF');
        }
        return $this;
    }
    
    /**
     * @return type 
     */
    function getCF(){
        return $this->_cf;
    }
    
    /**
     * @return \Eruda_Core 
     */
    function resetFolders(){
        $this->_folders = array();
        return $this;
    }
    
    /**
     * @param array(string) $folder
     * @return \Eruda_Core
     * @throws Exception 
     */
    function setFolders($folders) {
        if($folders!=null && is_array($folders)) {
			$this->_folders = $folders;
        } else {
            throw new Exception('Eruda_Core::setFolders - INVALIDS FOLDERS : '.$folders);
        }
        return $this;
    }
    
    /**
     * @param string $folder
     * @param string $dir
     * @return \Eruda_Core
     * @throws Exception 
     */
    function addFolder($folder, $dir) {
        if($folder!=null && is_string($folder) && strlen($folder)>0) {
            if($dir!=null && is_string($dir) && strlen($dir)>0) {
                $folder = strtolower($folder);
                $this->_folders[$folder] = $dir;
            } else {
                throw new Exception('Eruda_Core::addFolder - INVALID DIRECTORY : '.$dir);
            }
        } else {
            throw new Exception('Eruda_Core::addFolder - INVALID FOLDER : '.$folder);
        }
        return $this;
    }
    
    /**
     * @return array(string) 
     */
    function getFolders(){
        return $this->_folders;
    }
}

?>
