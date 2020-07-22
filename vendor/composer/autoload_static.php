<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3ca2f65022a2efe2069e0b82ad3e481d
{
    public static $files = array (
        '76a0f347bef7184fba317f43cc43c839' => __DIR__ . '/../..' . '/src/Helpers/Constants.php',
        '34fac92b7f438d1e9b9a12cad227c720' => __DIR__ . '/../..' . '/src/Helpers/Functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BdWebNinja\\WPHelper\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BdWebNinja\\WPHelper\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3ca2f65022a2efe2069e0b82ad3e481d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3ca2f65022a2efe2069e0b82ad3e481d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
