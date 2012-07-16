<?php

class Eruda {
    static protected $_uri;
    static protected $_base;
    static protected $_method;
    static protected $_router;
    static protected $_cf;
    static protected $_mailer;
    static protected $_params;
    static protected $_environment;
    static protected $_dbcon = array();
    static protected $_mv;
    static protected $_folders = array();
    
    static function init(){
        self::$_router = null;
        self::$_base = '';
        $url = explode('?',$_SERVER['REQUEST_URI']);
        self::setUri($url[0]);
        self::setMethod($_SERVER['REQUEST_METHOD']);
        
        self::$_cf = null;
        self::$_params = array();
    }
    
    static function parseUri() {
        $uri = preg_replace('~'.self::$_base.'~', '', self::$_uri, 1);
        if($uri[0]=='/') $uri = substr($uri, 1);
        self::setCF(self::$_router->run($uri, self::$_method, self::$_params));
    }
    
    static function setRouter($router) {
        self::$_router = $router;
    }
    
    static function getRouter(){
        return self::$_router;
    }
    static function setBase($base) {
        self::$_base = $base;
    }
    static function getBase() {
        return self::$_base;
    }
    
    static function setUri($uri) {
        self::$_uri = $uri;
    }
    
    static function getUri() {
        return self::$_uri;
    }
    
    static function setMethod($method) {
        self::$_method = $method;
    }
    
    static function getMethod() {
        return self::$_method;
    }
    
    static function setCF($cf) {
        self::$_cf = $cf;
    }
    
    static function getCF(){
        return self::$_cf;
    }
    
    static function resetFolders(){
        self::$_folders = array();
    }
    
    static function setFolders($folders) {
        self::$_folders = $folders;
    }
    
    static function addFolder($folder, $dir) {
        $folder = strtolower($folder);
        self::$_folders[$folder] = $dir;
    }
    
    static function getFolders(){
        return self::$_folders;
    }
    
    static function getDBConnector($i = 0){
        return self::$_dbcon[$i];
    }
    
    static function setDBConnector($connector){
        self::$_dbcon[] = $connector;
    }
    
    static function getMailer(){
        return self::$_mailer;
    }
    
    static function setMailer($mailer){
        self::$_mailer = $mailer;
    }
    
    static function runController(){
        $temp = self::$_cf;
        $i=0;
        do {
            try {
                $controller_name = 'Eruda_Controller_'.$temp->getController();
                $function_name =$temp->getFunction();

                $controller = new $controller_name(self::$_params, self::$_method=='HEADER');
                $controller->ini();
                $temp = $controller->$function_name();
                $controller->end();
                $i++;
            } catch (Exception $e) {
                $controller = new Eruda_Controller_Error(null, self::$_method=='HEADER');
                $controller->ini();
                $temp = $controller->E500();
                $controller->end();
            }
        }while(($temp instanceof Eruda_CF) && $i<5);
        
        if($i>=5){
            $controller = new Eruda_Controller_Error(null, self::$_method=='HEADER');
            $controller->ini();
            $temp = $controller->E500();
            $controller->end();
        }
        self::$_mv = $temp;
    }
    
    
    static function runCron($fun = 'Index'){
        $controller = new Eruda_Cron();
        try {
            $controller->ini();
            $controller->$fun();
            $controller->end();
        } catch (Exception $e) {
            $controller->log('Error '.print_r(e,true));
        }
    }
    
    static function show(){
        self::$_mv->show();
    }
}


class Eruda_Router {
    protected $_def = array();
    protected $_err = array();
    protected $_ext = array();
    
    function run($uri, $method, &$params) {
        if(is_string($uri) && strlen($uri)>0) {
            foreach ($this->_ext as $key => $router) {
                if(preg_match('~^'.$key.'.*$~', $uri, $matches)) {
                    array_shift($matches); 
                    foreach ($matches as $value) {
                        $params[] = $value;
                    }
                    $uri = preg_replace ('~^'.$key.'~', '', $uri);
                    return $router->run($uri, $method, $params);
                }
            }
        } else {
            if(isset($this->_def[$method])){
                return $this->_def[$method];
            } else if(isset($this->_def['DEFAULT'])){
                return $this->_def['DEFAULT'];
            }
        }
        if(isset($this->_err[$method])){
            return $this->_err[$method];
        } else if(isset($this->_err['DEFAULT'])){
            return $this->_err['DEFAULT'];
        } else {
            throw new Exception('Eruda_Router::run - NOT DEFAULT METHOD');
        }
    }
}

class Eruda_CF {
    public static $_methods = array('DEFAULT', 'GET', 'POST', 'PUT', 'DELETE', 'HEAD');
    
    protected $_meth;
    protected $_cont;
    protected $_func;
    
    
    function __construct($controller = null, $function = null, $method = 'DEFAULT') { 
        $this->_meth = $method;
        if($controller!=null) {
            $this->_cont = $controller;
        } else {
            $this->_cont = 'Index';
        }
        if($function!=null) {
            $this->_func = $function;
        } else {
            $this->_func = 'Index';
        }
    }
    
    function getController() {
        return $this->_cont;
    }
    
    function getFunction() {
        return $this->_func;
    }
    
}

abstract class Eruda_Controller {
    protected $_onlyheader;
    protected $_params;
    
    function __construct($params, $onlyheader=false){
        if(is_array($params))
            $this->_params = $params;
        
        if($onlyheader)
            $this->_onlyheader=true;
        else
            $this->_onlyheader = false;
    }
    
    abstract function ini();
    abstract function end();
}

interface Eruda_DBConnector {
    function connect();
    function disconnect();
    function insertOne($table, $attr, $values);
    function insertMulti($table, $attr, $values);
    function lastID();
    function update($table, $values, $where);
    function updateID($table, $values, $id);
    function updateVal($table, $values, $where);
    function delete($table, $where);
    function deleteID($table, $id);
    function deleteVal($table, $attr, $val);
    function selectID($table, $id, $object=null);
    function selectOne($table, $values, $start=0, $object=null);
    function selectAll($table, $order=null, $start=0, $total = 999999, $object=null);
    function selectType($table, $object=null, $random = false);
    function selectMulti($table, $values, $order=null, $start=0, $total = 999999, $object=null);
    function selectCount($table, $group=null, $order=null);
    function selectCountValues($table, $values = array());
}


class Eruda_MV {
    protected $_model;
    protected $_view;
    
    function __construct($view=null, $model=null) {
        if($view!=null)
            $this->setView ($view);
        if($model!=null)
            $this->setModel ($model);
    }
    function getModel(){
        return $this->_model;
    }
    
    function setModel($model){
        $this->_model = $model;
    }
    
    function getView(){
        return $this->$_view;
    }
    function setView($view){
        $this->_view = $view;
        return $this;
    }
    
    
    function show(){
        $this->_view->show($this->_model);
    }
}

abstract class Eruda_Model {
    function __set($attr, $value){
        if(method_exists($this, 'set_' . $attr)){
            call_user_func(array($this, 'set_' . $attr), $value);
        }
    }
    
    function __get($attr){
        if(method_exists($this, 'get_' . $attr)){
            return call_user_func(array($this, 'get_' . $attr));
        }
    }
    
    function __construct($vals = array()){
        if(is_array($vals))
            foreach($vals as $key=> $value) 
                $this->__set($key, $value);
    }
    
    abstract function __toString();
}


abstract class Eruda_Mailer {
    protected $from;
    
    function __construct($from) {
        $this->from = $from;
    }
    
    abstract function send($to, $subject, $message);
}


abstract class Eruda_Header {
    protected $_avaliveTypes = array();
    protected $_type;
    
    function __construct(){}
    function validType($type) {
        return in_array($type, $this->_avaliveTypes);
    }
    
    function setType($type) {
        $this->_type = $type;
    }
    
    abstract function printDOCTYPE();
    abstract function printHeader($folders = array());
}

abstract class Eruda_View {
    abstract function show($model);
}


class Eruda_Form {
    protected $return;
    protected $errors;
    protected $fields;
    
    function __construct($object=null) {
        if($object!=null) {
            $object = 'Eruda_Model_'.$object;
            $this->return = new $object();
        } else {
            $this->return = array();
        }
        $this->errors = array();
        $this->fields = array();
    }
    
    function addField($key, $field){
        $this->fields[$key] = $field;
        return $this;
    }
    
    function validate(){
        $valid = true;
        foreach ($this->fields as $field) {
            if(!$field->validate()){
                $valid = false;
                    $this->errors[] = $field->get_error();
            }
        }
        
        if($this->return instanceof Eruda_Model) {
            foreach ($this->fields as $key => $field) {
                $this->return->__set($key, $field->get_value());
            }
        } else if(is_array( $this->return)) {
            foreach ($this->fields as $key => $field) {
                $this->return[$key]= $field->get_value();
            }
        }
        
        return $valid;
    }
    
    function getValue(){
        return $this->return;
    }
    
    function getErrors(){
        return $this->errors;
    }
}


class Eruda_Field {
    protected $form_field;
    protected $value;
    protected $error;
    protected $validators;
    protected $required;
    
    function __construct($form_field, $required = null){
        $this->form_field = $form_field;
        $this->validators = array();
        $this->required = $required;
    }
    
    function add_validator($validator){
        $this->validators[] = $validator;
        return $this;
    }
    
    function validate(){
        if(isset($_POST[$this->form_field]) && strlen(trim($_POST[$this->form_field]))>0) {
            $this->value = trim($_POST[$this->form_field]);
            foreach ($this->validators as $validator) {
                if(!$validator->valid($this->value)) {
                    $this->error = $validator->get_error();
                    return false;
                }
            }
            return true;
        } else {
            $this->value = null;
            if($this->required!=null){
                $this->error = $this->required;
                return false;
            } else
                return true;
        }
    }
    
    function get_error(){
        return $this->error;
    }
    
    function get_value(){
        return $this->value;
    }
}


class Eruda_Field_Array extends Eruda_Field {
    function validate(){
        $this->value = array();
        if(isset($_POST[$this->form_field]) && is_array($_POST[$this->form_field]) && count($_POST[$this->form_field])>0){
            foreach($_POST[$this->form_field] as $k => $field){
                if(strlen(trim($field))>0) {
                    $this->value[$k] = $field;
                    foreach ($this->validators as $validator) {
                        if(!$validator->valid($field)) {
                            $this->error = $validator->get_error();
                            break;
                        }
                    }
                }
            }
        }
        return count($this->error)==0;
    }
}

class Eruda_Field_AreaArray extends Eruda_Field {
    function validate(){
        $this->value = array();
        if(isset($_POST[$this->form_field]) && strlen($_POST[$this->form_field])>0){
            $lines = explode('
', $_POST[$this->form_field]);
            foreach($lines as $line){
                if(strlen(trim($line))>0) {
                    $vals = array();
                    $vars =  explode(',', $line);
                    foreach ($vars as $var) {
                        $var = trim($var);
                        if(strlen($var)>0){
                            $vals[] = $var;
                            foreach ($this->validators as $validator) {
                                if(!$validator->valid($var)) {
                                    $this->error = $validator->get_error();
                                    break;
                                }
                            }
                        }
                    }
                    if(count($vals)>0) {
                        $this->value[] = $vals;
                    }
                }
            }
        }
        return count($this->error)==0;
    }
}

abstract class Eruda_Validator {
    protected $error;
    abstract function valid($val);
    
    function get_error(){
        return $this->error;
    }
}


function __autoload($class_name) {
    $inc = ini_get('include_path');
    if(is_file($inc.$class_name.'.php')) {
        include $class_name . '.php';
    } else if(preg_match('~^Eruda_Model_.*$~', $class_name)) {
        if(is_file($inc.'Models/'.$class_name.'.php'))
            include 'Models/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_Interface_.*$~', $class_name)) {
        if(is_file($inc.'Interfaces/'.$class_name.'.php'))
            include 'Interfaces/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_Helper_.*$~', $class_name)) {
        if(is_file($inc.'Helpers/'.$class_name.'.php'))
            include 'Helpers/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_Controller_.*$~', $class_name)) {
        if(is_file($inc.'Controllers/'.$class_name.'.php'))
            include 'Controllers/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_Mapper_.*$~', $class_name)) {
        if(is_file($inc.'Mappers/'.$class_name.'.php'))
            include 'Mappers/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_View_.*$~', $class_name)) {
        if(is_file($inc.'Views/'.$class_name.'.php'))
            include 'Views/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_MV_.*$~', $class_name)) {
        if(is_file($inc.'MV/'.$class_name.'.php'))
            include 'MV/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_Header_.*$~', $class_name)) {
        if(is_file($inc.'Headers/'.$class_name.'.php'))
            include 'Headers/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_DBConnector_.*$~', $class_name)) {
        if(is_file($inc.'Connectors/'.$class_name.'.php'))
            include 'Connectors/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_Validator_.*$~', $class_name)) {
        if(is_file($inc.'Validators/'.$class_name.'.php'))
            include 'Validators/'.$class_name . '.php';
    } else if(preg_match('~^Eruda_Mailer_.*$~', $class_name)) {
        if(is_file($inc.'Mailers/'.$class_name.'.php'))
            include 'Mailers/'.$class_name . '.php';
    } else if(is_file($inc.'Extra/'.$class_name.'.php')){
        include 'Extra/'.$class_name . '.php';
    }else{
        throw new Exception('__autoload - CLASS NOT FOUND : '.$class_name);
    }
        
}
?>
