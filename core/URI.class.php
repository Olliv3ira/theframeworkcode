<?php

namespace core;

class URI {

    private static $request, $uri, $root_name, $module, $controller, $action, $params;

    private static function getParams()
    {        
        //retorna os dados da uri em um array
        self::$request = explode('/',$_SERVER['REQUEST_URI']); 

        //retorna os dados de ROOTNAME em um array
        self::$root_name = explode('/', ROOTNAME);

        //remove diretório root, caso existe
        foreach (self::$root_name as $key => $value) {
            
            if(isset(self::$request[$key+1]) &&  $value == self::$request[$key+1]) {
                
                unset(self::$request[$key+1]);
                
            }

        }

        //limpa os valores nulos e vázios do array
        self::$request = array_filter(self::$request);
        
        //recria os índices do array
        self::$request = array_values(self::$request);
        
        return self::$request;

    }
    
    public static function getURI()
    {
        for($i = 0; count(self::getParams()) > $i; $i++) {
            
            if(HMVC) {
                
                if($i == 0) { 

                    self::$module = self::getParams()[$i];
                    
                } elseif($i == 1) { 
                    
                    self::$controller = self::getParams()[$i];
                    
                } elseif($i == 2) {
                    
                    self::$action = self::getParams()[$i];

                } elseif($i > 2) {
                    
                    array_push(self::$params,self::getParams()[$i]);
                    
                }
                
            } else {
                
                if($i == 0) { 

                    self::$controller = $request[$i];

                } elseif($i == 1) {
                    
                    self::$controller = $request[$i];

                } elseif($i > 1) {
                    
                    array_push(self::$params,$request[$i]);
                    
                }

            }         
        }

        if(HMVC) {
            
            self::$uri = array(
                'module' => (self::$module?self::$module:DEFAULTMODULE),
                'controller' => (self::$controller?self::$controller:DEFAULTCONTROLLER),
                'action' => (self::$action==''?'index':self::$action),
                'params' => self::$params
            );
            
        } else {
            
            self::$uri = array(
                'controller' => (self::$controller?self::$controller:DEFAULTCONTROLLER),
                'action' => (self::$action==''?'index':self::$action),
                'params' => self::$params
            );
            
        }  
        
        return (object)self::$uri;
               
    }

}