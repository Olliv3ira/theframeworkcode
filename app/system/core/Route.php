<?php

namespace app\system\core;

class Route extends Validate {

    private $module, $controller, $method, $params, $route, $root_name, $namespace, $result, $request;

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
        
        self::setRouteParams($this->route);
    }
        
    private function setRequest($request)
    {
        switch($request)
        {
            case 'GET':
                $this->request['get'] = $_GET;
            break;

            case 'POST':
                $this->request['post'] = $_POST;
            break;

            case 'PUT':
                $this->request['put'] = $_PUT;
            break;

            case 'DELETE':
                $this->request['delete'] = $_DELETE;
            break;

            default:
                $this->request = array();
            break;
        }
        
    }


    public function getRequest()
    {   
        //seta as requisição de acordo com a solicitaçãodo usuário
        self::setRequest($GLOBALS['_SERVER']['REQUEST_METHOD']);
        
        return (object) $this->request;
    }

    private function setRouteParams(Array $route)
    {
        for($i = 0; count($route) > $i; $i++)
        {
            if(HMVC)
            {
                if($i == 0): //retorna o modulo
                    $this->module = $route[$i];
                elseif($i == 1): //retorna o controller
                    $this->controller = $route[$i];
                elseif($i == 2): //retorna o metodo
                    $this->method = $route[$i];
                elseif($i > 2): //retorna os parâmetros a serem tratados pelo método
                    array_push($this->params,$route[$i]);
                endif;                
            }
            else
            {
                if($i == 0): //retorna o controller
                    $this->controller = $route[$i];
                elseif($i == 1): //retorna o metodo
                    $this->method = $route[$i];
                elseif($i > 1): //retorna os parâmetros a serem tratados pelo método
                    array_push($this->params,$route[$i]);
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
               
    }
    
    private function getRouteParams()
    {
        return (object) $this->route;
    }

    private function getController()
    {           
        if(HMVC)
        {
            $this->error = parent::controllerValidate(self::getRouteParams()->controller, self::getRouteParams()->module)['message'];
            $this->namespace = Path::getPath()->namespace.self::getRouteParams()->module."\\controllers\\".self::getRouteParams()->controller;
        }
        else
        {
            $this->error = parent::controllerValidate(self::getRouteParams()->controller)['message'];
            $this->namespace = Path::getPath()->namespace."Controllers\\".self::getRouteParams()->controller;            
        }

        if($this->error)
        {
            $this->result = die($this->error);
        }
        else
        {
            $this->result = $this->namespace;
        }

        return new $this->result();
    }
    

    public function run()
    {

        if(method_exists(self::getController(),self::getRouteParams()->method))
        {
            $method = self::getRouteParams()->method;

            if(!empty(self::getRouteParams()->params))
            {
                $this->result = self::getController()->$method(self::getRouteParams()->params);
            }
            else
            {
                $this->result = self::getController()->$method();                
            }            
            
        }else
        {
            $this->result = die("Erro: O método \"".self::getRouteParams()->method."\" não existe.");
        }

        return $this->result;

    }

}