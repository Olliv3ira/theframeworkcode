<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd62b393add1d5c9621f57616834d446c
{
    public static $classMap = array (
        'app\\core\\Controller' => __DIR__ . '/../..' . '/app/core/Controller.class.php',
        'app\\core\\Database' => __DIR__ . '/../..' . '/app/core/Database.class.php',
        'app\\core\\Model' => __DIR__ . '/../..' . '/app/core/Model.class.php',
        'app\\core\\Path' => __DIR__ . '/../..' . '/app/core/Path.class.php',
        'app\\core\\Route' => __DIR__ . '/../..' . '/app/core/Route.class.php',
        'app\\core\\Validate' => __DIR__ . '/../..' . '/app/core/Validate.class.php',
        'app\\core\\helpers\\Text' => __DIR__ . '/../..' . '/app/helpers/Text.php',
        'app\\src\\modules\\mymodule\\controllers\\MyController' => __DIR__ . '/../..' . '/app/src/modules/mymodule/controllers/MyController.class.php',
        'app\\src\\modules\\mymodule\\models\\MyModel' => __DIR__ . '/../..' . '/app/src/modules/mymodule/models/MyModel.class.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitd62b393add1d5c9621f57616834d446c::$classMap;

        }, null, ClassLoader::class);
    }
}
