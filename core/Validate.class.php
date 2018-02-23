<?php

namespace core;

use core\Error;

class Validate{

    private $model, $controller, $error, $result;
    
    private function getFile(String $dir, String $file)
    {     
        $this->result = '';
                
        foreach (scandir($dir) as $key => $item){
            
            if(strnatcasecmp ($item,$file.".class.php") === 0){
                $file = stristr($item,$file.".class.php");
                $this->result = str_replace(".class.php","",$file);
            }
            
        }
        
        return $this->result;
    }
    
    protected function moduleValidate(String $module)
    {   

        if($module == '') {
            
            Error::setError(array( 'message' => 'O campo módulo é obrigatório!'));
            
        }
        
        if(!is_dir(Path::getPath()->directory.$module)) {
            
            Error::setError(array( 'message' => 'O módulo "'.$module.'" não foi encontrado!'));
            
        }
        
    }

    protected function controllerValidate(String $controller, String $module = '')
    {        

        if(HMVC) {
            
            self::moduleValidate($module);
            
            if(empty(Error::countError())) {
                
                if(!($this->controller = self::getFile(Path::getPath()->directory.$module.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR,$controller))) {
                    
                    Error::setError(array( 'message' => 'O controller "'.$controller.'" não foi encontrado no módulo "'.$module.'"'));
                    
                }
                
            }
            
        } else {
            
            if(!($this->controller = self::getFile(Path::getPath()->directory.'controllers'.DIRECTORY_SEPARATOR,$controller))) {
                
                Error::setError(array( 'message' => 'O controller "'.$controller.'" não foi encontrado.'));

            }
            
        }         
        
        if(Error::countError()) {
            
            $this->result = false;
            
        } else {
            
            $this->result = $this->controller;
            
        }

        return $this->result;
        
    }
   
    protected function modelValidate($model, $module = '')
    {

        if(HMVC) {
            
            self::moduleValidate($module);
            
            if(empty(Error::countError())) {
                
                if(!($this->model = self::getFile(Path::getPath()->directory.$module.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR,$model))) {
                    
                    Error::setError(array( 'message' => 'O model "'.$model.'" não foi encontrado no módulo "'.$module.'".'));
                    
                }
                
            }
            
        } else {
            
            if(!($this->model = self::getFile(Path::getPath()->directory.'models'.DIRECTORY_SEPARATOR,$model))) {
                
                Error::setError(array( 'message' => 'Error: O model "'.$model.'" não foi encontrado.'));
                
            }
            
        }  
        
        if(empty(Error::countError())) {
            
            return $this->model;
            
        } 
        
    }
    
    protected function viewValidate(String $view, String $module = '')
    {        

        if(HMVC) {
            
            self::moduleValidate($module);

            if(empty(Error::countError())) {
                
                if(!file_exists(Path::getPath()->directory.$module.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$view.'.php')) {
                    
                    Error::setError(array('message' => 'A view "'.$view.'" não foi encontrada no módulo "'.$module.'".'));
                    
                }
                
            }
            
        } else {

            if(!file_exists(Path::getPath()->directory.'views'.DIRECTORY_SEPARATOR.$view.'.php')) {
                
                Error::setError(array( 'message' => 'Error: A view "'.$view.'" não foi encontrada.'));

            }
            
        }

                
    }
    
    protected function templateValidate(String $template)
    {        
        
        if(!file_exists(Path::getPath()->template.$template.'.php')) {
            
            Error::setError(array( 'message' => 'O template "'.$template.'" não foi encontrado.'));
            
        }
        
    }

}