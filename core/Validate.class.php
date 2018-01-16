<?php

namespace core;

class Validate{

    private $module, $model, $controller, $method, $error, $result;
    
    private function moduleValidate($module)
    {   

        if($module == '')
        {
            $this->error = "Error: O campo módulo é obrigatório! \n";
        }
        
        if(!is_dir(Path::getPath()->directory.$module))
        {
            $this->error = "Error: O módulo \"".$module."\" não foi encontrado.";
        }

        if($this->error)
        {
            $this->result = array('error' => true, 'message' => $this->error);
        }
        else
        {
            $this->result = array('error' => false, 'message' => '');
        }

        return $this->result;
        
    }
    
    private function getFile($dir,$file)
    {     
        $this->result = '';
                
        foreach (scandir($dir) as $key => $item){
            
            if(strnatcasecmp ($item,$file.".class.php") === 0){
                $file = stristr($item,$file.".class.php");
                $this->result = str_replace(".class.php","",$file);
            }
        }
        
        return $this->result;
    }

    protected function controllerValidate($controller, $module = '')
    {        

        if(HMVC)
        {           
            $this->error = self::moduleValidate($module)['message'];

            if(!$this->error)
            {
                
                if(!($this->controller = self::getFile(Path::getPath()->directory.$module.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR,$controller)))
                {
                    $this->error .= "Error: O controller \"".$controller."\" não foi encontrado no módulo \"".$module."\".";
                }
            }
            
        }
        else
        {
            if(!($this->controller = self::getFile(Path::getPath()->directory.'controllers'.DIRECTORY_SEPARATOR,$controller)))
            {
                $this->error .= "Error: O controller \"".$controller."\" não foi encontrado no módulo \"".$module."\".";
            }
        }     
        
        if($this->error)
        {
            $this->result = array('error' => true, 'message' => $this->error, 'controller' =>'');
        }
        else
        {
            $this->result = array('error' => false, 'message' => '', 'controller' => $this->controller);
        }

        return $this->result;
    }
   
    protected function modelValidate($model, $module = '')
    {

        if(HMVC)
        {           
            $this->error = self::moduleValidate($module)['message'];

            if(!$this->error)
            {
                
                if(!($this->model = self::getFile(Path::getPath()->directory.$module.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR,$model)))
                {
                    $this->error .= "Error: O model \"".$model."\" não foi encontrado no módulo \"".$module."\".";
                }
            }
            
        }
        else
        {
            if(!($this->model = self::getFile(Path::getPath()->directory.'models'.DIRECTORY_SEPARATOR,$model)))
            {
                $this->error .= "Error: O model \"".$model."\" não foi encontrado.";
            }
        }     

        if($this->error)
        {
            $this->result = array('error' => true, 'message' => $this->error, 'model' => '');
        }
        else
        {
            $this->result = array('error' => false, 'message' => '', 'model' => $this->model);
        }

        return $this->result;
    }
    
    protected function viewValidate($view, $module = '')
    {        

        if(HMVC)
        {
            $this->error = self::moduleValidate($module)['message'];

            if(!$this->error)
            {
                if(!file_exists(Path::getPath()->directory.$module.'/views/'.$view.'.php'))
                {
                    $this->error = "Error: A view \"".$view."\" não foi encontrada no módulo \"".$module."\".";
                }
            }
        }
        else
        {

            if(!file_exists(Path::getPath()->directory.'views/'.$view.'.php'))
            {
                $this->error = "Error: A view \"".$view."\" não foi encontrada.";
            }
        }

        if($this->error)
        {
            $this->result = array('error' => true, 'message' => $this->error);
        }
        else
        {
            $this->result = array('error' => false, 'message' => '');
        }

        return $this->result;
    }
    
    protected function templateValidate(String $template)
    {        
        if(!file_exists(Path::getPath()->template.$template.'.php'))
        {
            $this->error = "Error: O template \"".$template."\" não foi encontrado.";
        }

        if($this->error)
        {
            $this->result = array('error' => true, 'message' => $this->error);
        }
        else
        {
            $this->result = array('error' => false, 'message' => '');
        }

        return $this->result;
    }

}