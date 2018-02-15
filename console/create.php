<?php

$argc; //quantidade de parametros
$argv; //parametros

$base_dir = dirname(__DIR__)."/app/src/modules/";

$comando = "";

$controller  = "<?php\n";
$controller .= "\n";
$controller .= "namespace app\src\modules\mymodule\controllers;\n";
$controller .= "\n";
$controller .= "class MyController extends \core\Controller{\n";
$controller .= "\n";
$controller .= "    public function index()\n";
$controller .= "    {\n";
$controller .= "\n";
$controller .= "        parent::loadView(array(\n";
$controller .= "            'template' => 'default',\n";
$controller .= "            'module' => 'mymodule',\n";
$controller .= "            'view' => 'myview')\n";
$controller .= "        );\n";
$controller .= "\n";       
$controller .= "    }\n";
$controller .= "\n";    
$controller .= "}";

$model  = "<?php\n";
$model .= "\n";
$model .= "namespace app\src\modules\mymodule\models;\n";
$model .= "\n";
$model .= "class MyModel extends \core\Model{\n";
$model .= "\n";
$model .= '    private $queryResult;'."\n";
$model .= "\n";
$model .= '    public function getText($str = "Olá mundo!")'."\n";
$model .= "    {\n";
$model .= '        return $str;'."\n";
$model .= "    }\n";
$model .= "\n";    
$model .= "}";

$view  = "<?php if(!defined('ENVIRONMENT')) { die('Error: Perfil não definido'); } ?>";

if($argc>1)
{
    
    $option = explode(":", $argv[2]);
    
    if(!in_array($option[0], array('controller','model','view'))) {
        die('Error: parameter not isset!');
    } elseif($option[0] == 'controller' && empty($option[1])) {
        die('Error: controller not informed!');
    } elseif($option[0] == 'model' && empty($option[1])) {
        die('Error: model not informed!');
    } elseif($option[0] == 'view' && empty($option[1])) {
        die('Error: view not informed!');
    }
   
    foreach($argv as $key => $item)
    {
        switch ($key){
            case 1:
                
                if(!is_dir($base_dir.strtolower($item))){
                    
                    $comando  = "mkdir ".$base_dir.strtolower($item).";";
                    $comando .= "mkdir ".$base_dir.strtolower($item).DIRECTORY_SEPARATOR."controllers;";
                    $comando .= "mkdir ".$base_dir.strtolower($item).DIRECTORY_SEPARATOR."models;";
                    $comando .= "mkdir ".$base_dir.strtolower($item).DIRECTORY_SEPARATOR."views;";
                    
                    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
                        $comando .= "chmod 777 -R ".$base_dir.strtolower($item).";";
                    }
                } 
                
                break;
            case 2:
                
                switch ($option[0])
                {
                    case 'controller':
                        $filename = $base_dir.strtolower($argv[1]).DIRECTORY_SEPARATOR."controllers".DIRECTORY_SEPARATOR.$option[1].".class.php";
                        
                        $controller = str_replace('MyController',$option[1],$controller);
                        if(isset($argv[3])) {
                            $controller = str_replace('myview',$argv[3],$controller);
                        }
                        $class = str_replace('mymodule',strtolower($argv[1]),$controller);
                        
                        break;
                    case 'model':
                        $filename = $base_dir.strtolower($argv[1]).DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR.$option[1].".class.php";
                        
                        $model = str_replace('MyModel',$option[1],$model);
                        $class = str_replace('mymodule',strtolower($argv[1]),$model);
                        break;
                    case 'view':
                        $filename = $base_dir.strtolower($argv[1]).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$option[1].".php";
                        
                        $class = $view;
                        break;
                }
                
                if(!file_exists($filename)) {
                    
                    $file = fopen($filename,"w");
                    fwrite($file, $class);
                    fclose($file);
                    
                    if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
                        $comando .= "chmod 777 -R $filename;";
                    }
                    
                }
                
                break;
        }
        
        if(!empty($comando))
        {
            $comando .= "composer dump-autoload -o -a";
            
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                exec($command);
            } else {
                shell_exec($comando);
            }
            
            $comando = "";
        }
        
    }
    
    
}else
{
    die('Error: Invalid commands!"');
}



