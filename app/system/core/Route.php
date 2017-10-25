<?php

namespace app\system\core;

class Route extends Validate {

    private $module, $controller, $method, $params = array(), $route = array(), $root_name, $namespace, $result, $Controller, $path;

    public function __construct()
    {
        //retorna os dados da uri em um array
        $this->route = explode('/',$_SERVER['REQUEST_URI']); 

        //retorna os dados de ROOTNAME em um array
        $this->root_name = explode('/', ROOTNAME);

        //remove diretório root, caso existe
        foreach ($this->root_name as $key => $value) {
            
            if(isset($this->route[$key+1]) &&  $value == $this->route[$key+1])
            {
                unset($this->route[$key+1]);
            }

        }

        //limpa os valores nulos e vázios do array
        $this->route = array_filter($this->route);
        
        //recria os índices do array
        $this->route = array_values($this->route);
    }
   
    protected function getRequest()
    {
        switch($GLOBALS['_SERVER']['REQUEST_METHOD'])
        {
            case 'GET':
                $this->request = $_GET;
            break;

            case 'POST':
                $this->request = $_POST;
            break;

            case 'PUT':
                $this->request = $_PUT;
            break;

            case 'DELETE':
                $this->request = $_DELETE;
            break;

            default:
                $this->request = array();
            break;
        }
        
        return $this->request;
    }

    public function run()
    {
        for($i = 0; count($this->route) > $i; $i++)
        {
            if(HMVC)
            {
                if($i == 0): //retorna o modulo
                    $this->module = $this->route[$i];
                elseif($i == 1): //retorna o controller
                    $this->controller = $this->route[$i];
                elseif($i == 2): //retorna o metodo
                    $this->method = $this->route[$i];
                elseif($i > 2): //retorna os parâmetros a serem tratados pelo método
                    array_push($this->params,$this->route[$i]);
                endif;                
            }
            else
            {
                if($i == 0): //retorna o controller
                    $this->controller = $this->route[$i];
                elseif($i == 1): //retorna o metodo
                    $this->method = $this->route[$i];
                elseif($i > 1): //retorna os parâmetros a serem tratados pelo método
                    array_push($this->params,$this->route[$i]);
                endif;
            }         
        }

        if(HMVC)
        {
            $this->route = array(
                'module' => ($this->module?$this->module:DEFAULTMODULE),
                'controller' => ($this->controller?$this->controller:DEFAULTCONTROLLER),
                'method' => ($this->method==''?'index':$this->method),
                'params' => $this->params
            );
        }
        else
        {
            $this->route = array(
                'controller' => ($this->controller?$this->controller:DEFAULTCONTROLLER),
                'method' => ($this->method==''?'index':$this->method),
                'params' => $this->params
            );
        }
                
        return (object) $this->route;        
    }

    private function getRoute()
    {
        $this->path = parent::getPath();
        $this->route = self::run();

        if(HMVC)
        {
            $this->error = parent::controllerValidate($this->route->controller, $this->route->module)['message'];
            $this->path->namespace .= $this->route->module."\\controllers\\".$this->route->controller;
        }
        else
        {
            $this->error = parent::controllerValidate($this->route->controller)['message'];
            $this->path->namespace .= "Controllers\\".$this->route->controller;            
        }

        if($this->error)
        {
            $this->result = die($this->error);
        }
        else
        {
            $this->result = $this->path->namespace;
        }

        return $this->result;
    }

    public function runMethod()
    {
        $this->Controller = self::getRoute();

        if(method_exists($this->Controller = new $this->Controller(),$this->route->method))
        {
            $method = $this->route->method;

            if(!empty($this->route->params))
            {
                $this->result = $this->Controller->$method($this->route->params);
            }
            else
            {
                $this->result = $this->Controller->$method();                
            }            
            
        }else
        {
            $this->result = die("Erro: O método \"".$this->route->method."\" não existe.");
        }

        return $this->result;

    }

}