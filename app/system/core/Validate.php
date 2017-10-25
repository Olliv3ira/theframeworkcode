<?php

namespace app\system\core;

class Validate extends Path{

    private $module, $model, $controller, $method, $path, $error, $result;

    private function moduleValidate($module)
    {   
        $this->path = parent::getPath();

        if($module == '')
        {
            $this->error = "Error: O campo módulo é obrigatório! \n";
        }

        if(!is_dir($this->path->directory.$module))
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
        $this->path = parent::getPath();

        if(HMVC)
        {           
            $this->error = self::moduleValidate($module)['message'];

            if(!$this->error)
            {
                if(!file_exists($this->path->directory.$module.'/controllers/'.$controller.'.php'))
                {
                    $this->error .= "Error: O controller \"".$controller."\" não foi encontrado no módulo \"".$module."\".";
                }
            }
            
        }
        else
        {
            if(!file_exists($this->path->directory.'/controllers/'.$controller.'.php'))
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
        $this->path = parent::getPath();

        if(HMVC)
        {           
            $this->error = self::moduleValidate($module)['message'];

            if(!$this->error)
            {
                if(!file_exists($this->path->directory.$module.'/models/'.$model.'.php'))
                {
                    $this->error .= "Error: O model \"".$model."\" não foi encontrado no módulo \"".$module."\".";
                }
            }
            
        }
        else
        {
            if(!file_exists($this->path->directory.'/models/'.$model.'.php'))
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
        $this->path = parent::getPath();

        if(HMVC)
        {
            $this->error = self::moduleValidate($module)['message'];

            if(!$this->error)
            {
                if(!file_exists($this->path->directory.$module.'/views/'.$view.'.php'))
                {
                    $this->error = "Error: A view \"".$view."\" não foi encontrada no módulo \"".$module."\".";
                }
            }
        }
        else
        {

            if(!file_exists($this->path->directory.'views/'.$view.'.php'))
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

}