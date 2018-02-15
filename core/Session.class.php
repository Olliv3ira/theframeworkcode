<?php

namespace core;

class Session {
            
    public static function start() 
    {    
        if(!isset($_SESSION)) {
            session_start();
        }
    }
    
    public static function setSession(Array $params)
    {      
        
        foreach ($params as $key => $param) {
            
            if(isset(self::getSession()->$key)) {
                self::remove($key);
            } 
            
            self::addSession($key,$param);
        }              
        
    }
    
    private static function addSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public static function getId()
    {
        self::start();
        
        return session_id();        
    }

    public static function getSession() 
    {           
        if(self::getId()) {
            return (object) $_SESSION;
        }
    }
    
    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }
    
    public static function destroy() 
    {   
        if(self::getId()) {            
            session_destroy();            
        }        
    }
    
}