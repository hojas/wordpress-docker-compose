<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname(dirname(dirname(dirname($vendorDir))));

return array(
    'TMDB\\' => array($vendorDir . '/api/tmdb_api/src'),
    'Curl\\' => array($vendorDir . '/php-curl-class/php-curl-class/src/Curl'),
    'App\\' => array($baseDir . '/wp-content/plugins/Importer/App', $baseDir . '/wp-content/plugins/Importer/App'),
);
