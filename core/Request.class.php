<?php

namespace core;

class Request {

    private static $type, $request;    
             
    public static function getRequest()
    {        
        self::$type = $GLOBALS['_SERVER']['REQUEST_METHOD'];
        
        switch(self::$type) {
            case 'GET':
                self::$request[strtolower(self::$type)] = $_GET;
            break;

            case 'POST':
                self::$request[strtolower(self::$type)] = $_POST;
            break;

            case 'PUT':
                self::$request[strtolower(self::$type)] = $_PUT;
            break;

            case 'DELETE':
                self::$request[strtolower(self::$type)] = $_DELETE;
            break;
        
            default:
                self::$request = null;
            break;
        }
    
        return (object)self::$request;
        
    }
    
}