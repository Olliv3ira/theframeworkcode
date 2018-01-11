<?php

namespace app\system\core;

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

    protected function controllerValidate($controller, $module = '')
    {
        

        if(HMVC)
        {           
            $this->error = self::moduleValidate($module)['message'];

            if(!$this->error)
            {
                if(!file_exists(Path::getPath()->directory.$module.'/controllers/'.$controller.'.php'))
                {
                    $this->error .= "Error: O controller \"".$controller."\" não foi encontrado no módulo \"".$module."\".";
                }
            }
            
        }
        else
        {
            if(!file_exists(Path::getPath()->directory.'/controllers/'.$controller.'.php'))
            {
                $this->error .= "Error: O controller \"".$controller."\" não foi encontrado.";
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
   
    protected function modelValidate($model, $module = '')
    {

        if(HMVC)
        {           
            $this->error = self::moduleValidate($module)['message'];

            if(!$this->error)
            {
                if(!file_exists(Path::getPath()->directory.$module.'/models/'.$model.'.php'))
                {
                    $this->error .= "Error: O model \"".$model."\" não foi encontrado no módulo \"".$module."\".";
                }
            }
            
        }
        else
        {
            if(!file_exists(Path::getPath()->directory.'/models/'.$model.'.php'))
            {
                $this->error .= "Error: O model \"".$model."\" não foi encontrado.";
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