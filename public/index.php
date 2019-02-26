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
// faire correspondre le deux premières lettres de la cat avec les deux première de la sous cat
$catSql = 'SELECT NomCat, NumCat FROM Categorie';
$subCatSql = 'SELECT NomsousCat, NumsousCat FROM SousCategorie';
$productsSql = 'SELECT NumProd, NomProd, PrixHT FROM Produit';

// envoi d'une requête SQL à la BDD et récupération du résultat sous forme de tableau PHP dans la variable `$items`
$categories = $conn->fetchAll($catSql);
$subCategories = $conn->fetchAll($subCatSql);
$products = $conn->fetchAll($productsSql);

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

$brand = 'LocaFox';

//voir pour faire un if soit côté templates soir côté public pour afficher la page différemment si le client est connecté ou non connecté.

echo $twig->render('index.html.twig', [
    // transmission de données au template
    'brand' => $brand,
    'categories' => $categories,
    'subCategories' => $subCategories,
    'products' => $products,
]);
