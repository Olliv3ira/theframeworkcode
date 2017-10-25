<?php

namespace app\system\core;

class Controller extends Route{

    private $module, $model, $view, $error, $result, $links, $helper;
    protected $request, $path;

    public function __construct()
    {
        $this->path = parent::getPath();
        $this->request = parent::getRequest();
        $this->result = array();
        $this->links = array('css' => '', 'js' => '');        
    }

    private function outputData($view = '')
    {
        
        if(!$view)
        {
            $this->view = $this->outputData;
        }
        else{
            $this->view = $view;
        }

        if(!file_exists($this->view))
        {
            $this->error = "Error: View não encontrada!";  
                      
            die($this->error);            
        }
        else{
            require_once($this->view);
        }
        
    }

    protected function getCSS(Array $files, $module = '')
    {
        $this->result = array();
        $this->module = $module;

        foreach($files AS $file)
        {
            if(HMVC)
            {
                array_push($this->result, '<link rel="stylesheet" href="'.$this->path->url.$this->module.'/views/custom/css/'.$file.'.css" />');   
            }
            else
            {
                array_push($this->result, '<link rel="stylesheet" href="'.$this->path->url.'/views/custom/css/'.$file.'.css" />');                
            }
        }

        return implode('<br />', $this->result);
    }

    protected function getJS(Array $files, $module = '')
    {
        $this->result = array();
        $this->module = $module;

        foreach($files AS $file)
        {
            if(HMVC)
            {
                array_push($this->result, '<script src="'.$this->path->url.$this->module.'/views/custom/js/'.$file.'.js"></script>');   
            }
            else
            {
                array_push($this->result, '<script src="'.$this->path->url.'/views/custom/js/'.$file.'.js"></script>');                   
            }
        }

        return implode('<br />', $this->result);
    }

    protected function getHelper(Array $helpers)
    {
        $this->result = array();

        foreach($helpers AS $helper)
        {
            $this->helper = "app\\System\\Helpers\\$helper";    
            $this->result[strtolower($helper)]= new $this->helper();
        }

        if(!empty($this->result))
        {
            $this->helper = $this->result;
        }

        return (object) $this->helper;
    }

    public function loadModel($model, $module = '')
    {
        $this->error = parent::modelValidate($model, $module)['message'];

        if($this->error)
        {
            $this->result = die($this->error);
        }
        else
        {
            if(HMVC)
            {
                 $this->model = $this->path->namespace.$module."\\models\\".$model;  
            }
            else
            {
                 $this->model = $this->path->namespace."models\\".$model;
            }

            $this->result = new $this->model();
        }
        
        return $this->result;
    }

    public function loadView(Array $params)
    {          
        if(HMVC)
        {
            $this->error = parent::viewValidate($params['view'], $params['module'])['message'];
        }
        else
        {
            $this->error = parent::viewValidate($params['view'])['message'];            
        }        

        if($this->error)
        {
            $this->result = die($this->error);
        }
        else
        {
            $this->loadData = isset($params['params'])?$params['params']:array();

            if(HMVC)
            {
                $this->outputData = $this->path->directory.$params['module']."/views/".$params['view'].".php";               
            }
            else
            {
                $this->outputData = $this->path->directory."/views/".$params['view'].".php";
            }
            
            if(isset($params['links']))
            {
                if(isset($params['links']['css']))
                {
                    $this->links['css'] = self::getCSS($params['links']['css'], $params['module']);
                }
                if(isset($params['links']['js']))
                {
                    $this->links['js'] = self::getJS($params['links']['js'], $params['module']);                
                }
            }

            $this->result = self::outputData(BASEDIR."public/templates/".$params['template'].".php");
        }   
        
        return $this->result;
    }
   
    
}