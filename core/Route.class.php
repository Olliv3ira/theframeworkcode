<?php

namespace core;

use core\URI;

class Route extends Validate {

    private $module, $controller, $params = array(), $namespace;

    private function getController()
    {           
        if(HMVC) {
            
            $this->controller = parent::controllerValidate(URI::getURI()->controller, URI::getURI()->module);
            $this->namespace = Path::getPath()->namespace.URI::getURI()->module."\\controllers\\".$this->controller;
            
        } else {
            
            $this->controller = parent::controllerValidate(URI::getURI()->controller);
            $this->namespace = Path::getPath()->namespace."\\controllers\\".$this->controller;
            
        }
                
        if(Error::countError()) {
            
            die(Error::getShowError());
            
        } else {            
                        
            return new $this->namespace;
            
        }
                
    }
    
    private function getAction(Controller $controller, String $action)
    {          
        $this->action = '';
        
        foreach(get_class_methods($controller) as $key => $item) {
            
            if(strnatcasecmp ($item,$action) === 0) {
                
                $this->action = stristr($item,$action);
                
            }   
            
        }
        
        if(empty($this->action)) {
            
            Error::setError(array('message' => 'A action "'.$action.'" não existe!'));
            
        } else {
            
            return $this->action;
            
        }
        
    }

    public function run()
    {     
        $action = self::getAction(self::getController(),URI::getURI()->action);
        
        if(Error::countError()) {
            
            die(Error::getShowError());
            
        } else {
            
            return self::getController()->$action(URI::getURI()->params);  
            
        }
    }

}