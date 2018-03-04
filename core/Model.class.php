<?php

namespace core;

class Model extends Database
{

    private $PDO = null, $query, $queryResult, $result;

    public function __construct()
    {
        
        $this->PDO = parent::connect();   
        
    }

    /**
     *
     * @param Array $params O nome do dono do depósito.
     */
    protected function create(Array $params)
    {       
        try {

            $this->query = "INSERT INTO ".$params['table']." (".(is_array($params['fields'])?implode(',',$params['fields']):$params['fields']).") VALUES (".(is_array($params['values'])?implode(',',$params['values']):$params['values']).")";
            $this->queryResul = $this->PDO->prepare($this->query);

            if(isset($params['debug']) && $params['debug'] == true) {

                return $this->queryResult;

            }

            $this->queryResult->execute();

            if ($this->queryResult->rowCount() > 0) {

                $this->result = true;

            } else {

                $this->result = false;

            }

            return $this->result;
            
        } catch (ErrorException $error) {
            
            Error::setError(array(
                'number' => $error->getCode(), 
                'message' => $error->getMessage()
            ));
            
            die(Error::getShowError());
        }
        
    }

    /**
     *
     * @param Array $params O nome do dono do depósito.
     */
    protected function read(Array $params)
    {
        try {
            
            $this->query = "SELECT ".(is_array($params['fields'])?implode(',',$params['fields']):$params['fields'])." FROM ".(is_array($params['tables'])?implode(',',$params['tables']):$params['tables'])." WHERE ".(is_array($params['where'])?implode(' ', $params['where']):$params['where'])." ".(isset($params['others'])?((is_array($params['others'])?implode(' ',$params['others']):$params['others'])):'');
            $this->queryResult = $this->PDO->prepare($this->query);

            if(isset($params['debug']) && $params['debug'] == true) {

                return $this->queryResult;

            }

            $this->queryResult->execute();

            if ($this->queryResult->rowCount() > 0) {

                $this->result = $this->queryResult->fetchAll(\PDO::FETCH_OBJ);            

            } else {

                $this->result = false;

            }

            return $this->result;
            
        } catch (ErrorException $error) {
            
            Error::setError(array(
                'number' => $error->getCode(), 
                'message' => $error->getMessage()
            ));
            
            die(Error::getShowError());
        }
        
    }

    /**
     *
     * @param Array $params O nome do dono do depósito.
     */
    protected function update(Array $params)
    {
        try {
            $this->query = "UPDATE ".$params['table']." SET ".(is_array($params['fields'])>1?implode(',',$params['fields']):$params['fields'])." WHERE ".(is_array($params['where'])?implode(' ', $params['where']):$params['where']);
            $this->queryResul = $this->PDO->prepare($this->query);

            if(isset($params['debug']) && $params['debug'] == true) {

                return $this->queryResult;

            }

            $this->queryResult->execute();

            if ($this->queryResult->rowCount() > 0) {

                $this->result = true;

            } else {

                $this->result = false;

            }

            return $this->result;
            
        } catch (ErrorException $error) {
            
            Error::setError(array(
                'number' => $error->getCode(), 
                'message' => $error->getMessage()
            ));
            
            die(Error::getShowError());
        }
        
    }

    protected function delete(Array $params)
    {
        try {
            $this->query = "DELETE FROM ".$params['table']." WHERE ".(is_array($params['where'])?implode(' ', $params['where']):$params['where']);
            $this->queryResul = $this->PDO->prepare($this->query);

            if(isset($params['debug']) && $params['debug'] == true) {

                return $this->queryResult;

            }

            $this->queryResult->execute();

            if ($this->queryResult->rowCount() > 0) {

                $this->result = true;

            } else {

                $this->result = false;

            }

            return $this->result;
            
        } catch (ErrorException $error) {
            
            Error::setError(array(
                'number' => $error->getCode(), 
                'message' => $error->getMessage()
            ));
            
            die(Error::getShowError());
        }
        
    }

    protected function query(Array $params)
    {
        try {
            
            $this->query = "SELECT ".implode(',', $params['fields'])." FROM ".implode($params['tables']).(isset($params['joins'])?implode(' ', $params['joins']):'')." WHERE ".(is_array($params['where'])?implode(' ', $params['where']):$params['where'])." ".(isset($params['others'])?((is_array($params['others'])?implode(' ',$params['others']):$params['others'])):'');
            $this->queryResul = $this->PDO->prepare($this->query);

            if(isset($params['debug']) && $params['debug'] == true) {

                return $this->queryResult;

            }

            $this->queryResult->execute();

            if ($this->queryResult->rowCount() > 0) {

                $this->result = $this->queryResult->fetchAll(\PDO::FETCH_OBJ);

            } else {

                $this->result = false;

            }

            return $this->result;
        
        } catch (ErrorException $error) {
            
            Error::setError(array(
                'number' => $error->getCode(), 
                'message' => $error->getMessage()
            ));
            
            die(Error::getShowError());
        }
        
    }
    
}
