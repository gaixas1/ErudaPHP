<?php
/**
 * Description of Eruda_Controller_User
 *
 * @author gaixas1
 */
class Eruda_Controller_User extends Eruda_Controller{
    protected $user;
    protected $header;
    
    public function ini() {
        Eruda::getDBConnector()->connect();
        
        $this->user = Eruda_Helper_Auth::getUser();
        
        if(!$this->_onlyheader) {
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
            $this->header->addCSS('userpage.css');
            $this->header->addJavascript('jquery.js');
            $this->header->addJavascript('user.js');
        }
    }
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    
    function LogForm() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: /' ) ;
                $this->end();
                exit();
            }
            
            
            $model = new Eruda_Model_LogForm('');
            
            $view = new Eruda_View_HTML('user', array('form'=>'logform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function LogIn() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: /' ) ;
                $this->end();
                exit();
            }
            /*
             * Falta comprobacion mediante Eruda_Form
             */
            $name = $_POST['user'];
            $pass = $_POST['pass'];
            $mantain = $_POST['mantain'];
            
            $userid = Eruda_Helper_Auth::LogIn($name, $pass, $mantain);
            
            if($userid > 0) {
                header( 'Location: /' ) ;
                $this->end();
                exit();
            }
            
            $model = new Eruda_Model_LogForm($name, 'Usuario o contraseña incorrecto');
            
            $view = new Eruda_View_HTML('user', array('form'=>'logform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function LogOut() {        
        Eruda_Helper_Auth::LogOut();
        header( 'Location: /' ) ;
        $this->end();
        exit();
    }
}

?>
