<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita630207c2a656ce9ae39c7d2801f9a75
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TMDB\\' => 5,
        ),
        'C' => 
        array (
            'Curl\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TMDB\\' => 
        array (
            0 => __DIR__ . '/..' . '/api/tmdb_api/src',
        ),
        'Curl\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-curl-class/php-curl-class/src/Curl',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../../../../..' . '/wp-content/plugins/Importer/App',
            1 => __DIR__ . '/../../../../..' . '/wp-content/plugins/Importer/App',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita630207c2a656ce9ae39c7d2801f9a75::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita630207c2a656ce9ae39c7d2801f9a75::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
