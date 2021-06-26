<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfe31addc7bcf7335def63dc952ba6c05
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfe31addc7bcf7335def63dc952ba6c05::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfe31addc7bcf7335def63dc952ba6c05::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfe31addc7bcf7335def63dc952ba6c05::$classMap;

        }, null, ClassLoader::class);
    }
}
