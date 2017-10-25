<?php

$config = array(
    'root_name' => 'theframeworkcode', //development or production
    'default_module' => 'mymodule', // obrigatório para arquitetura HMVC
    'default_controller' => 'mycontroller',
    'base_dir' => dirname(__DIR__).'/',
    'base_url' => 'http://localhost/theframeworkcode/'
);

//dados de conexão com a base de dados
$db['default'] = array(
    'driver'   => '',
    'hostname' => '',
    'dbname' => '',
    'username' => '',
    'password' => ''
);

