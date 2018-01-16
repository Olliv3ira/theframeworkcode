<?php

namespace app\core;

use \PDOException;

class Database {

    private static $connection;
    private $driver, $hostname, $database, $username, $password, $error = array();
    
    public function __construct(){
        
        $this->erro       = false;
        
        $this->driver     = $GLOBALS['db']['default']['driver'];
        $this->hostname   = $GLOBALS['db']['default']['hostname'];
        $this->database   = $GLOBALS['db']['default']['dbname'];
        $this->username   = $GLOBALS['db']['default']['username'];
        $this->password   = $GLOBALS['db']['default']['password'];

    }

    public function connect()
    {
        if(is_null(self::$connection))
        {                        
            try
            {
                if(is_null(self::__construct())){
                    self::__construct();
                }

                self::$connection = new \PDO("$this->driver:host=$this->hostname;dbname=$this->database", $this->username, $this->password);
            }
            catch(PDOException $error )
            {
                $this->error = 'Erro: '.$error->getMessage();
            }

            if($this->error)
            {
                die($this->error);
            }
        }

        return self::$connection;
        
    }

}