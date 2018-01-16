<?php

namespace app\core;

class Controller extends Route{

    private $module, $model, $file, $error, $result, $links, $helper;

    public function __construct()
    {
        parent::__construct();
    }

    private function outputData($file = '')
    {
        
        if(!$file)
        {
            $this->file = $this->outputData;
        }
        else{
            $this->file = $file;
        }

        if(!file_exists($this->file))
        {
            $this->error = "Error: View não encontrada!";  
                      
            die($this->error);            
        }
        else{
            require_once($this->file);
        }
        
    }

    protected function getCSS(Array $files, $module = '')
    {
        $this->result = array();
        $this->module = $module;

        foreach($files AS $file)
        {
            array_push($this->result, '<link rel="stylesheet" href="'.BASEURL.'public/custom/css/'.$file.'.css" />');
        }
        
        return implode('<br />', $this->result);
    }

    protected function getJS(Array $files, $module = '')
    {
        $this->result = array();
        $this->module = $module;

        foreach($files AS $file)
        {
            array_push($this->result, '<script src="'.BASEURL.'public/custom/js/'.$file.'.js"></script>');
        }

        return implode('<br />', $this->result);
    }

    protected function getHelper(Array $helpers)
    {
        $this->result = array();

        foreach($helpers AS $helper)
        {
            $this->helper = "app\\helpers\\$helper";
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
        $this->result = parent::modelValidate($model, $module); 
        if($this->result['error'])
        {
            $this->result = die($this->result['message']);
        }
        else
        {
            if(HMVC)
            {
                 $this->model = Path::getPath()->namespace.$module."\\models\\".$this->result['model'];  
            }
            else
            {
                 $this->model = Path::getPath()->namespace."models\\".$this->result['model'];
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
            $this->loadData = isset($params['params']['data'])?$params['params']['data']:array();

            if(HMVC)
            {
                $this->outputData = Path::getPath()->directory.$params['module']."/views/".$params['view'].".php";               
            }
            else
            {
                $this->outputData = Path::getPath()->directory."/views/".$params['view'].".php";
            } 
            
            
            if(isset($params['params']['links']))
            {
                if(isset($params['params']['links']['css']))
                {
                    $this->links['css'] = self::getCSS($params['params']['links']['css'], $params['module']);
                }
                if(isset($params['params']['links']['js']))
                {
                    $this->links['js'] = self::getJS($params['params']['links']['js'], $params['module']);                
                }
            }

            $this->result = self::outputData(Path::getPath()->template.$params['template'].".php");
        }   
        
        return $this->result;
    }
    
    public function loadTemplate($template)
    {          
        $this->error = parent::templateValidate($template)['message'];       

        if($this->error)
        {
            $this->result = die($this->error);
        }
        else
        {     
            $this->result = self::outputData(Path::getPath()->template.$template.".php");
        }   
        
        return $this->result;
    }
   
    
}