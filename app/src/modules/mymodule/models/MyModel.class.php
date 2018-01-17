<?php

namespace app\src\modules\mymodule\models;

class MyModel extends \core\Model{

    private $queryResult;

    public function getText($str = "Olá mundo!")
    {
        return parent::read(array('fields' => '*', 'tables' => 'users', 'where' => '1=1'));
    }
    
}