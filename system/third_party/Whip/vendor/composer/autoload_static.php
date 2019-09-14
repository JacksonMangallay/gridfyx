<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit107f3a6b067a83cac07b8d540894adac
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vectorface\\Whip\\' => 16,
            'Vectorface\\WhipTests\\' => 21,
            'VectorFace\\Whip\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vectorface\\Whip\\' => 
        array (
            0 => __DIR__ . '/..' . '/vectorface/whip/src',
        ),
        'Vectorface\\WhipTests\\' => 
        array (
            0 => __DIR__ . '/..' . '/vectorface/whip/tests',
        ),
        'VectorFace\\Whip\\' => 
        array (
            0 => __DIR__ . '/..' . '/vectorface/whip/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit107f3a6b067a83cac07b8d540894adac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit107f3a6b067a83cac07b8d540894adac::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
