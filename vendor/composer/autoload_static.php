<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita9726bbf7e352406ba8177b2c3bd0e20
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JustDisableIt\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JustDisableIt\\' => 
        array (
            0 => __DIR__ . '/../..' . '/source',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita9726bbf7e352406ba8177b2c3bd0e20::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita9726bbf7e352406ba8177b2c3bd0e20::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita9726bbf7e352406ba8177b2c3bd0e20::$classMap;

        }, null, ClassLoader::class);
    }
}
