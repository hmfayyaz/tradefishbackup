<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit66eda2affb0035211d4135f93bee3f8a
{
    public static $files = array (
        '78684bf02183e16ed86099084edb2d20' => __DIR__ . '/../..' . '/includes/Utils/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Iqonic\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Iqonic\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit66eda2affb0035211d4135f93bee3f8a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit66eda2affb0035211d4135f93bee3f8a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
