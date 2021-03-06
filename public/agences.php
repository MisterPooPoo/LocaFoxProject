<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

// activation du système d'autoloading de Composer
require __DIR__.'\..\vendor\autoload.php';

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

$agenceSql = 'SELECT * FROM Agence';

$agencies = $conn->fetchAll($agenceSql);
// instanciation du chargeur de templates
$loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new Twig_Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

// chargement de l'extension Twig_Extension_Debug
$twig->addExtension(new Twig_Extension_Debug());

//voir pour faire un if soit côté templates soir côté public pour afficher la page différemment si le client est connecté ou non connecté.

echo $twig->render('agences.html.twig', [
  'agencies' => $agencies,

]);
