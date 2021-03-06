<?php

namespace core;

use \PDO;
use \PDOException;

class Database {

    private static $connection;
    private $charset, $driver, $hostname, $database, $username, $password;
    
    private function setParams(){
        
        $this->charset    = $GLOBALS['db']['default']['charset'];
        $this->driver     = $GLOBALS['db']['default']['driver'];
        $this->hostname   = $GLOBALS['db']['default']['hostname'];
        $this->database   = $GLOBALS['db']['default']['dbname'];
        $this->username   = $GLOBALS['db']['default']['username'];
        $this->password   = $GLOBALS['db']['default']['password'];

    }

    public function connect()
    {
        if(is_null(self::$connection)) {                        
            try {
                
                self::setParams();
                
                self::$connection = new PDO("$this->driver:host=$this->hostname;dbname=$this->database;charset=$this->charset", "$this->username", "$this->password",array(PDO::ATTR_PERSISTENT => true));

            } catch(PDOException $error ) {
                
                Error::setError(array(
                    'number' => $error->getCode(), 
                    'message' => $error->getMessage()
                ));
                
            }

            if(Error::countError()) {
                
                die(Error::getShowError());
                
            }
            
        }
        
        return self::$connection;
        
    }

}