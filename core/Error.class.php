<?php

namespace core;

class Error {

    private static $error, $count; 
    
    public function __construct() {
        self::$error = array();
    }
             
    public static function setError(Array $error)
    {        
        self::$error[] =  (isset($error['number'])?'Error '.$error['number'].': ':'').$error['message'];
    }
    
    public static function getError()
    {
        return (object)self::$error;
    }
    
    public static function getShowError()
    {
        if(self::$error) {
            return implode('<br />', self::$error);
        }
    }
    
    public static function countError()
    {
        self::$count = 0;

        if(!is_null(self::$error)){
            self::$count = count(self::$error);
        }

        return self::$count;
    }

}