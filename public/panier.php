<?php

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

// activation du système d'autoloading de Composer
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

$productsSql = 'SELECT NumProd, NomProd, PrixHT FROM Produit';
$products = $conn->fetchAll($productsSql);

if(isset($_GET)) {
  $_SESSION['panier'] = $_GET;
} else {
  $_SESSION['panier'] = [];
}

var_dump($_SESSION['panier']);


echo $twig->render('panier.html.twig', [
    // transmission de données au template
    'products' => $products,
    'session' => $_SESSION,
    'get' => $_GET,
]);
