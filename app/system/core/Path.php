<?php

namespace app\system\core;

class Path {

    private $path;

    protected function getPath()
    {        
        if(HMVC)
        {
            $this->path =  array(
                'directory' => BASEDIR."app/modules/",
                'url' => BASEURL."app/modules/",                
                'namespace' => "\\app\\modules\\"
            );
        }
        else
        {
            $this->path =  array(
                'directory' => BASEDIR."app/",
                'url' => BASEURL."app/",
                'namespace' => "\\app\\"
            );
        }

        return (object) $this->path;
        
    }

}