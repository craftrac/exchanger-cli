<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInited90feac975214fc55b0a93a88a0624b
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Exchanger\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Exchanger\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'AltoRouter' => __DIR__ . '/..' . '/altorouter/altorouter/AltoRouter.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInited90feac975214fc55b0a93a88a0624b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInited90feac975214fc55b0a93a88a0624b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInited90feac975214fc55b0a93a88a0624b::$classMap;

        }, null, ClassLoader::class);
    }
}
