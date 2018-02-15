<?php

namespace core;

class Error {

    private static $error; 
    
    public function __construct() {
        self::$error = array();
    }
             
    public static function setError(Array $error)
    {        
        self::$error[] =  'Error '.$error['number'].': '.$error['message'];
    }
    
    public static function getError()
    {
        return (object)self::$error;
    }
    
    public static function getShowError()
    {
        return implode('<br />', self::$error);
    }
    
    public static function countError()
    {
        return count(self::$error);
    }

}