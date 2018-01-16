<?php

namespace app\core;

class Route extends Validate {

    private $module, $controller, $method, $params = array(), $route = array(), $root_name, $namespace, $result, $request;

    public function __construct()
    {                           
        self::filterURI();        
    }
    
    private function filterURI(){
        
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
        
        self::setParams($this->route);   
        
        //seta as requisição de acordo com a solicitaçãodo usuário
        self::setRequest($GLOBALS['_SERVER']['REQUEST_METHOD']);
        
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
        return (object) $this->request;
    }

    private function setParams(Array $route)
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
    
    private function getParams()
    {
        return (object) $this->route;
    }

    private function getController()
    {           
        if(HMVC)
        {
            $this->result = parent::controllerValidate(self::getParams()->controller, self::getParams()->module);
            $this->namespace = Path::getPath()->namespace.self::getParams()->module."\\controllers\\".$this->result['controller'];
        }
        else
        {
            $this->result = parent::controllerValidate(self::getParams()->controller);
            $this->namespace = Path::getPath()->namespace."\\controllers\\".$this->result['controller'];
            
        }
                
        if($this->result['error'])
        {
            die($this->result['message']);
        }
        else
        {
            $this->result = $this->namespace;
        }
        
        return new $this->result();
    }
    
    private function getMethod($controller,$method)
    {          
        $this->result = '';
        
        foreach(get_class_methods($controller) as $key => $item)
        {
            if(strnatcasecmp ($item,$method) === 0){
                $this->result = stristr($item,$method);
            }            
        }
        
        return $this->result;
    }

    public function run()
    {
        
        if(!$method = self::getMethod(self::getController(),self::getParams()->method))
        {
            $this->result = die("Erro: O método \"".self::getParams()->method."\" não existe.");            
        }
        else
        {
            $this->result = self::getController()->$method(self::getParams()->params);
        }

        return $this->result;

    }

}