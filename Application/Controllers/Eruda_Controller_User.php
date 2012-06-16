<?php
/**
 * Description of Eruda_Controller_User
 *
 * @author gaixas1
 */
class Eruda_Controller_User extends Eruda_Controller{
    protected $user;
    protected $header;
    protected $refered;
    
    public function ini() {
        Eruda::getDBConnector()->connect();
        
        $this->setRefered();
        
        $this->user = Eruda_Helper_Auth::getUser();
        
        if(!$this->_onlyheader) {
            $this->header = new Eruda_Header_HTML();
            $this->header->setType('HTML5');
            $this->header->setMetatag('Description', 'FallenSoulFansub, todos nuestros mangas on-line para tu disfrute.');
            $this->header->append2Title(Eruda::getEnvironment()->getTitle());
            $this->header->addCSS('userpage.css');
            $this->header->addJavascript('jquery.js');
        }
    }
    
    public function end() {    
        Eruda::getDBConnector()->disconnect();
    }
    
    
    function LogForm() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            
            $model = new Eruda_Model_LogForm('');
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'logform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function LogIn() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $form = new Eruda_Form('LogForm');
            $form->addField('username', 
                    new Eruda_Field('user', 'El nombre de usuario no puede estar en blanco.')
                    );
            $form->addField('pass', 
                    new Eruda_Field('pass', 'La contraseña no puede estar en blanco.')
                    );
            $form->addField('mantain', new Eruda_Field('mantain'));
            
            $form->validate();
            
            $model = $form->getValue();
            
            $loged = false;
            
            $name = null;
            
            if(count($form->getErrors())>0) {
                $model->set_errors($form->getErrors());
            } else {
                $name = $model->get_username();
                $pass = $model->get_pass();
                $mantain = $model->get_mantain();


                $userid = Eruda_Helper_Auth::LogIn($name, $pass, $mantain);

                if(!($userid > 0))
                    $model->set_errors(array('Usuario o contraseña incorrecto'));
                else
                    $loged = true;
            }
            
            if($loged){
                $model = new Eruda_Model_Message('Bienvenido '.$name);
                $this->header->addJavascript('user.js');
                $view = new Eruda_View_HTML('user', array('form'=>'okmessage'));
            }else
                $view = new Eruda_View_HTML('user', array('form'=>'logform'));
            
            $model->set_ref($this->refered);
            
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function RegisterForm() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            
            $model = new Eruda_Model_RegForm();
            
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'regform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function Register() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $form = new Eruda_Form('RegForm');
            
            $fieldUser = new Eruda_Field('user', 'El nombre de usuario no puede estar en blanco.');
            $fieldUser->add_validator(new Eruda_Validator_Lenght(4,25,
                    'El nombre de usuario ha de tener un minimo de 4 caracteres.',
                    'El nombre de usuario no puede superar los 25 caracteres.'
                    ));
            $form->addField('username', $fieldUser);
            
            $fieldPass = new Eruda_Field('pass', 'La contraseña no puede estar en blanco.');
            $fieldPass->add_validator(new Eruda_Validator_Lenght(6,20,
                    'La contraseña ha de tener un minimo de 4 caracteres.',
                    'La contraseña no puede superar los 20 caracteres.'
                    ))->add_validator(new Eruda_Validator_Equal('pass2',
                            'Las contraseñas no coinciden'
                    ));
            $form->addField('pass', $fieldPass);
            
            $fieldMail = new Eruda_Field('mail', 'La dirección de correo no puede estar en blanco.');
            $fieldMail->add_validator(new Eruda_Validator_Mail('El mail introducido no es correcto'));
            $form->addField('mail', $fieldMail);
            
            
            $form->validate();
            
            $model = $form->getValue();
            
            
            if(count($form->getErrors())>0) {
                $model->set_errors($form->getErrors());
            } else {
                $name = $model->get_username();
                $pass = $model->get_pass();
                $mail = $model->get_mail();
                
                if(Eruda_Mapper_User::getName($name)){
                    $model->add_error('El nombre de usuario ya esta registrado.');
                }

                if(Eruda_Mapper_User::getMail($mail)){
                    $model->add_error('La dirección de correo ya esta registrada.');
                }
            }
            
            if(!$model->has_errors()) {
                $user = new Eruda_Model_User();
                
                $user->set_name($name);
                $user->set_mail($mail);
                $user->set_pass(Eruda_Helper_Auth::hashPassword($pass));
                Eruda_Mapper_User::save($user);
                Eruda_Helper_Auth::setUser($user);
                
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'regform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    
    function EditForm() {        
        if(!$this->_onlyheader) {
            if(!($this->user->get_id()>0)) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $model = new Eruda_Model_EditForm();
            
            $model->set_user($this->user);
            
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'editform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function Edit() {        
        if(!$this->_onlyheader) {
            if(!($this->user->get_id()>0)) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $form = new Eruda_Form('EditForm');
            
            $fieldPass = new Eruda_Field('actpass', 'La contraseña actual no puede estar en blanco.');
            $form->addField('passact', $fieldPass);
            
            $fieldPass2 = new Eruda_Field('newpass', 'La nueva contraseña no puede estar en blanco.');
            $fieldPass2->add_validator(new Eruda_Validator_Lenght(6,20,
                    'La nueva contraseña ha de tener un minimo de 4 caracteres.',
                    'La nueva contraseña no puede superar los 20 caracteres.'
                    ))->add_validator(new Eruda_Validator_Equal('newpass2',
                            'Las contraseñas no coinciden'
                    ));
            $form->addField('passnew', $fieldPass2);
            
            
            $form->validate();
            
            $model = $form->getValue();
            
            $model->set_user($this->user);
            
            if(count($form->getErrors())>0) {
                $model->set_errors($form->getErrors());
            } else {
                if(Eruda_Helper_Auth::checkPass($this->user, $model->get_passact())) {
                    $pass = Eruda_Helper_Auth::hashPassword($model->get_passnew());
                    Eruda_Mapper_User::updatePass($this->user, $pass);
                    $model->set_changed();
                } else {
                    $model->set_errors(array('La contraseña actual es incorrecta'));
                }
            }
            
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'editform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    
    function RecuperaForm() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $model = new Eruda_Model_RecForm();
            
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'recform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function Recupera() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $sendedUser = new Eruda_Field('senduser', true);
            $sendedMail = new Eruda_Field('sendmail', true);
            
            $form = new Eruda_Form('RecForm');
            $model = null;
            $user = null;
            if($sendedUser->validate()) {
                $fieldUser = new Eruda_Field('user', 'El nombre de usuario no puede estar en blanco.');
                $fieldUser->add_validator(new Eruda_Validator_Lenght(4,25,
                        'El nombre de usuario ha de tener un minimo de 4 caracteres.',
                        'El nombre de usuario no puede superar los 25 caracteres.'
                        ));
                $form->addField('username', $fieldUser);
                
                $form->validate();
                $model = $form->getValue();
                if(count($form->getErrors())>0) {
                    $model->set_errors($form->getErrors());
                } else {
                    $user = Eruda_Mapper_User::getName($model->get_username());
                    if($user==null) {
                        $model->set_errors(array('El nombre de usuario no esta registrado'));
                    }
                }
            } else if($sendedMail->validate()){
                $fieldMail = new Eruda_Field('mail', 'La dirección de correo no puede estar en blanco.');
                $fieldMail->add_validator(new Eruda_Validator_Mail('El mail introducido no es correcto.'));
                $form->addField('mail', $fieldMail);
                
                $form->validate();
                $model = $form->getValue();
                if(count($form->getErrors())>0) {
                    $model->set_errors($form->getErrors());
                } else {
                    $user = Eruda_Mapper_User::getMail($model->get_mail());
                    if($user==null) {
                        $model->set_errors(array('La dirección de correo no esta registrada.'));
                    }
                }
            } else {
                $model = new Eruda_Model_RecForm();
                $model->set_errors("Petición desconocida.");
            }
            
            
            if($user!=null) {
                $rand = Eruda_Helper_Auth::random_gen(40);
                Eruda_Mapper_User::setRecup($user, $rand);
                
                $msg = '
<html>
<head>
<title>Recuperación de Contraseña</title>
</head>
<body>
<p><strong>Hola, '.$user->get_name().'</strong></p>
<p>Se ha generado una solicitud de Recuperación de Contraseña desde nuestro Sitio Web - '.Eruda::getEnvironment()->getTitle().' <br/>
Si usted no ha solicitado este mensaje, por favor ignórelo. Si sigue recibiéndolo contáctenos 
a <strong>'.Eruda::getEnvironment()->getMail().'</strong>.</p>
<p>Sigue este enlace para recuperar el control de tu cuenta: <br/>
<a href="'.Eruda::getEnvironment()->getBaseURL().'user/recupera/'.$user->get_id().'-'.$rand.'/">'.Eruda::getEnvironment()->getBaseURL().'user/recupera/'.$user->get_id().'-'.$rand.'/</a> <br/>
El enlace será valido durante las proximas 48h</p>
<p><strong>Gracias por seguirnos<strong></p>
</body>
</html>';
                $mailer = Eruda::getMailer();
                $mailer->send($user->get_mail(), 'Recuperación de contraseña', $msg);
                
                header( 'Location: /user/recupera/sended/' ) ;
                $this->end();
                exit();
            }
            
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'recform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function RecuperaSended() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $model = new Eruda_Model_Message('Petición de nueva contraseña enviada con exito.');
            
            $model->set_ref($this->refered);
            $this->header->addJavascript('user.js');
            
            $view = new Eruda_View_HTML('user', array('form'=>'okmessage'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function RecuperaChanged() {        
        if(!$this->_onlyheader) {
            $model = new Eruda_Model_Message('Contraseña modificada con exito.');
            
            $model->set_ref($this->refered);
            
            $this->header->addJavascript('user.js');
            $view = new Eruda_View_HTML('user', array('form'=>'okmessage'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function RecuperaMailForm() {        
        if(!$this->_onlyheader) {
            if($this->user->get_id()>0) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $id = $this->_params[0];
            $rec = substr($this->_params[1],0,40);
            
            $user = Eruda_Mapper_User::getByID_Rec($id,$rec);
            
            if($user==null) {
                return new Eruda_CF('User', 'RecuperaError');
            }
            
            $model = new Eruda_Model_EditForm();
            
            $model->set_user($user);
            
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'recnewpassform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    function RecuperaMail() {        
        if(!$this->_onlyheader) {
            if(($this->user->get_id()>0)) {
                header( 'Location: '.$this->refered ) ;
                $this->resetRefered();
                $this->end();
                exit();
            }
            
            $id = $this->_params[0];
            $rec = substr($this->_params[1],0,40);
            
            $user = Eruda_Mapper_User::getByID_Rec($id,$rec);
            
            if($user==null) {
                return new Eruda_CF('User', 'RecuperaError');
            }
            
            
            $form = new Eruda_Form('EditForm');
            
            $fieldPass2 = new Eruda_Field('newpass', 'La nueva contraseña no puede estar en blanco.');
            $fieldPass2->add_validator(new Eruda_Validator_Lenght(6,20,
                    'La nueva contraseña ha de tener un minimo de 4 caracteres.',
                    'La nueva contraseña no puede superar los 20 caracteres.'
                    ))->add_validator(new Eruda_Validator_Equal('newpass2',
                            'Las contraseñas no coinciden'
                    ));
            $form->addField('passnew', $fieldPass2);
            
            $form->validate();
            
            $model = $form->getValue();
            
            $model->set_user($user);
            
            if(count($form->getErrors())>0) {
                $model->set_errors($form->getErrors());
            } else {
                $pass = Eruda_Helper_Auth::hashPassword($model->get_passnew());
                Eruda_Mapper_User::updatePass($user, $pass);
                
                Eruda_Helper_Auth::setUser($user);
                
                header( 'Location: /user/recupera/changed/' ) ;
                $this->end();
                exit();
            }
            
            $model->set_ref($this->refered);
            
            $view = new Eruda_View_HTML('user', array('form'=>'recnewpassform'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    function RecuperaError() {        
        if(!$this->_onlyheader) {
            $model = new Eruda_Model_Message('El codigo de recuperación es incorrecto o ha caducado.');
            
            $model->set_ref(Eruda::getEnvironment()->getBaseURL());
            
            $view = new Eruda_View_HTML('user', array('form'=>'errormessage'));
            $view->setHeader($this->header);
            return new Eruda_MV($view, $model);
        }
        return null;
    }
    
    
    
    function LogOut() {        
        Eruda_Helper_Auth::LogOut();
        header( 'Location: '.$this->refered ) ;
        $this->resetRefered();
        $this->end();
        exit();
    }
    
    
    
    function setRefered(){
        if(isset($_SERVER['HTTP_REFERER']) && strlen($_SERVER['HTTP_REFERER'])>0 && !preg_match('~/user/.*$~', $_SERVER['HTTP_REFERER'])){
            $this->refered = $_SERVER['HTTP_REFERER'];
            $_SESSION['REFERER'] = $this->refered;
        } else if(!$this->refered && isset($_SESSION['REFERER']) && strlen($_SESSION['REFERER'])>0){
            $this->refered = $_SESSION['REFERER'];
        } else {
            $this->refered = Eruda::getEnvironment()->getBaseURL();
            $_SESSION['REFERER'] = $this->refered;
        }
    }
    
    function resetRefered(){
        unset($_SESSION['REFERER']);
    }
}

?>
