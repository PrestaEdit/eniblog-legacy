<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1ed971cc736d9addb69f93b6829e24f2
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Eni\\Blog\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Eni\\Blog\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'EniBlog' => __DIR__ . '/../..' . '/eniblog.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1ed971cc736d9addb69f93b6829e24f2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1ed971cc736d9addb69f93b6829e24f2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1ed971cc736d9addb69f93b6829e24f2::$classMap;

        }, null, ClassLoader::class);
    }
}
