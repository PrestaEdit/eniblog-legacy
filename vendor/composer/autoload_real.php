<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit1ed971cc736d9addb69f93b6829e24f2
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit1ed971cc736d9addb69f93b6829e24f2', 'loadClassLoader'), true, false);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit1ed971cc736d9addb69f93b6829e24f2', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit1ed971cc736d9addb69f93b6829e24f2::getInitializer($loader));

        $loader->register(false);

        return $loader;
    }
}
