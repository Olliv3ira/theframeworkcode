<?php

namespace core;

class Controller extends Route{

    private $model, $file, $error, $result, $links, $helper, $library;

    private function outputData($file = '')
    {
        
        if(!$file) {
            
            $this->file = $this->outputData;
            
        } else {
            
            $this->file = $file;
            
        }

        if(!file_exists($this->file)) {
            
            Error::setError(array( 'message' => 'View não encontrada!')); 
            
        } else {
            
            require_once($this->file);
            
        }        
        
    }

    protected function getCSS(Array $files)
    {
        $this->result = array();

        foreach($files AS $file) {
            
            array_push($this->result, '<link rel="stylesheet" href="'.BASEURL.'public/custom/css/'.$file.'.css" />');
            
        }
        
        return implode('<br />', $this->result);
        
    }

    protected function getJS(Array $files)
    {
        $this->result = array();

        foreach($files AS $file) {
            
            array_push($this->result, '<script src="'.BASEURL.'public/custom/js/'.$file.'.js"></script>');
            
        }

        return implode('<br />', $this->result);
        
    }

    protected function getHelper(Array $helpers)
    {
        $this->result = array();

        foreach($helpers AS $helper) {
            
            $this->helper = "app\\helpers\\$helper";
            $this->result[strtolower($helper)]= new $this->helper();
            
        }

        if(!empty($this->result)) {
            
            $this->helper = $this->result;
            
        }

        return (object) $this->helper;
        
    }
    
    protected function getLibrary(Array $libraries)
    {
        $this->result = array();

        foreach($libraries AS $library) {
            
            $this->library = "app\\libraries\\$library";
            $this->result[strtolower($library)] = new $this->library();
            
        }

        if(!empty($this->result)) {
            
            $this->library = $this->result;
            
        }

        return (object) $this->library;
        
    }

    public function loadModel(String $model, String $module = '')
    {
        $this->model = parent::modelValidate($model, $module); 
                    
        if(Error::countError()) {
            
            die(Error::getShowError());
            
        } else {
            
            if(HMVC) {
                
                 $this->model = Path::getPath()->namespace.$module."\\models\\".$this->model;
                 
            } else {
                
                 $this->model = Path::getPath()->namespace."models\\".$this->model;
                 
            }
                                    
            return (object)(new $this->model());
            
        }
        
    }

    public function loadView(Array $params)
    {       
        
        if(HMVC) {
            
            parent::viewValidate($params['view'], $params['module']);
            
        } else {
            
            parent::viewValidate($params['view']);
            
        }        

        if(Error::countError()) {
            
            die(Error::getShowError());
            
        } else {
            
            $this->loadData = isset($params['params']['data'])?$params['params']['data']:array();

            if(HMVC) {
                
                $this->outputData = Path::getPath()->directory.$params['module']."/views/".$params['view'].".php"; 
                
            } else {
                
                $this->outputData = Path::getPath()->directory."/views/".$params['view'].".php";
                
            }             
            
            if(isset($params['params']['links'])) {
                
                if(isset($params['params']['links']['css'])) {
                    
                    $this->links['css'] = self::getCSS($params['params']['links']['css'], $params['module']);
                    
                }
                
                if(isset($params['params']['links']['js'])) {
                    
                    $this->links['js'] = self::getJS($params['params']['links']['js'], $params['module']);
                    
                }
                
            }

            self::outputData(Path::getPath()->template.$params['template'].".php");
            
            if(Error::countError()) {
                die(Error::getShowError());
            }
            
        }
        
    }
    
    public function loadTemplate($template)
    {          
        parent::templateValidate($template);       

        if(Error::countError()) {
            
            die(Error::getShowError());
            
        } else {
            
            return self::outputData(Path::getPath()->template.$template.".php");
            
        }
        
    }
    
    public function redirect($link = '')
    {          
        return header("Location: ".BASEURL.$link);
    }
    
}