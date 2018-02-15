<?php

namespace core;

class Request {

    private static $request;    
             
    public static function setRequest($type)
    {        
        switch($type) {
            case 'GET':
                self::$request[strtolower($type)] = $_GET;
            break;

            case 'POST':
                self::$request[strtolower($type)] = $_POST;
            break;

            case 'PUT':
                self::$request[strtolower($type)] = $_PUT;
            break;

            case 'DELETE':
                self::$request[strtolower($type)] = $_DELETE;
            break;
        }
    }
    
    public static function getRequest()
    {
        return (object)self::$request;
    }

}