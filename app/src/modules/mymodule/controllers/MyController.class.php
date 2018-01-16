<?php

namespace app\src\modules\mymodule\controllers;

class MyController extends \core\Controller{

    public function index()
    {

        parent::loadView(array(
            'template' => 'default',
            'module' => 'mymodule',
            'view' => 'myview')
        );
       
    }
    
}