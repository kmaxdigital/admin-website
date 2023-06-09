<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9d99494860e50f0a4e9d48cc13758dff
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit9d99494860e50f0a4e9d48cc13758dff::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9d99494860e50f0a4e9d48cc13758dff::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9d99494860e50f0a4e9d48cc13758dff::$classMap;

        }, null, ClassLoader::class);
    }
}
