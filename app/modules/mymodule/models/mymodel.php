<?php

namespace app\modules\mymodule\models;

class MyModel extends \app\system\core\Model{

    private $queryResult;

    public function getText($str = "Olá mundo!")
    {
        return parent::read(array('fields' => '*', 'tables' => 'users', 'where' => '1=1'));
    }
    
}