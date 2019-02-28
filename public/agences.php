<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

require __DIR__.'/../vendor/autoload.php';

$config = new Configuration();

$connectionParams = [
    'driver'    => 'pdo_mysql',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'dbname'    => 'BdLocafox',
    'user'      => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
];

$conn = DriverManager::getConnection($connectionParams, $config);

$loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');

$twig = new Twig_Environment($loader, [
    'debug' => true,
    'strict_variables' => true,
]);
$twig->addExtension(new Twig_Extension_Debug());

$brand = 'LocaFox';

echo $twig->render('agences.html.twig', [
    'brand' => $brand,
]);
