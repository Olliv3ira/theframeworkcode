<?php

namespace app\system\core;

class Path {

    private $path;
      
    public static function getPath()
    {        
        if(HMVC)
        {
            $path =  array(
                'public' => BASEDIR."public/",
                'template' => BASEDIR."public/templates/",
                'directory' => BASEDIR."app/modules/",
                'url' => BASEURL."app/modules/",                
                'namespace' => "\\app\\modules\\"
            );
        }
        else
        {
            $path =  array(
                'public' => BASEDIR."public/",
                'template' => BASEDIR."public/templates/",
                'directory' => BASEDIR."app/",
                'url' => BASEURL."app/",
                'namespace' => "\\app\\"
            );
        }

        return (object) $path;
        
    }

}