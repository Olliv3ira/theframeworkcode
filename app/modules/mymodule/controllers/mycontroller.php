<?php

namespace app\modules\mymodule\controllers;

class MyController extends \app\system\core\Controller{

    public function index()
    {

        parent::loadView(array(
            'template' => 'default',
            'module' => 'mymodule',
            'view' => 'myview')
        );
       
    }
    
}