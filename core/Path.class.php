<?php

namespace core;

class Path {

    private static $path;
      
    public static function getPath()
    {        
        if(HMVC) {
            
            self::$path =  array(
                'public' => BASEDIR."public".DIRECTORY_SEPARATOR,
                'template' => BASEDIR."public".DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR,
                'directory' => BASEDIR."app".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR,
                'namespace' => "app\\src\\modules\\"
            );
            
        } else {
            
            self::$path =  array(
                'public' => BASEDIR."public".DIRECTORY_SEPARATOR,
                'template' => BASEDIR."public".DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR,
                'directory' => BASEDIR."app".DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR,
                'namespace' => "app\\"
            );
            
        }

        return (object) self::$path;
        
    }

}