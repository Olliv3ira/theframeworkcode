<?php if(!ENVIRONMENT) { die('Error: Perfil não definido'); }

use app\system\core as Core;

$routes = new Core\Route();
$routes->run();