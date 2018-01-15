<?php 

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
	define('ENVIRONMENT', isset($_SERVER['ENVIRONMENT']) ? $_SERVER['ENVIRONMENT'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 */
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * APPLICATION ARCHITECTURE
 *---------------------------------------------------------------
 *
 *  * This can be set TRUE or FALSE.
 *
 *     TRUE - to HMVC
 *     FALSE - to MVC
 *
 */
	define('HMVC', TRUE);


//carregamento dos parâmentros de configuração
require_once(dirname(__DIR__).'/config/config.php');

//carregamento das variáveis globais
require_once(dirname(__DIR__).'/config/defines.php');

//carregamento do autoload
require_once(dirname(__DIR__).'/vendor/autoload.php');

$routes = new app\core\Route();
$routes->run();