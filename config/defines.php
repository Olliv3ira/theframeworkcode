<?php if(!ENVIRONMENT) { die('Error: Perfil não definido'); }
######### CONFIGURAÇÃO DE VARIÁVEIS GLOBAIS #########

//define o caminho do diretório raiz
define('BASEDIR',$config['base_dir']);

//define o caminho da raiz da url
define('BASEURL',$config['base_url']);

define('ROOTNAME', $config['root_name']);

define('DEFAULTMODULE', $config['default_module']);

define('DEFAULTCONTROLLER', $config['default_controller']);
