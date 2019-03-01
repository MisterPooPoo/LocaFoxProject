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

$catSql = 'SELECT NomCat, NumCat FROM Categorie';
$subCatSql = 'SELECT NomsousCat, NumsousCat FROM SousCategorie';
$productsSql = 'SELECT NumProd, NomProd, PrixHT FROM Produit';
$agenceSql = 'SELECT * FROM Agence WHERE NumAgence="3" ';

$agency = $conn->fetchAll($agenceSql);
$categories = $conn->fetchAll($catSql);
$subCategories = $conn->fetchAll($subCatSql);
$products = $conn->fetchAll($productsSql);

$brand = 'LocaFox';

session_start();
if (isset($_SESSION['user'])) {
} else {
  $_SESSION = [];
}

echo $twig->render('index.html.twig', [
    // transmission de données au template
    'brand' => $brand,
    'categories' => $categories,
    'subCategories' => $subCategories,
    'session' => $_SESSION,
    'products' => $products,
    'get' => $_GET,
    'agency' => $agency,
]);
