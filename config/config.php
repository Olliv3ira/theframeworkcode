<?php if(!defined('ENVIRONMENT')) { die('Error: Perfil não definido'); }

$config = array(
    'root_name' => 'theframeworkcode', //dirtórório raiz do projeto
    'default_module' => 'mymodule', // obrigatório para arquitetura HMVC
    'default_controller' => 'mycontroller',
    'base_dir' => dirname(__DIR__).DIRECTORY_SEPARATOR,
    'base_url' => 'http://localhost/theframeworkcode'
);

//dados de conexão com a base de dados
$db['default'] = array(
    'driver'   => '',
    'hostname' => '',
    'dbname' => '',
    'username' => '',
    'password' => ''
);

