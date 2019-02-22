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

$errors = [];
$session = '';
$email ='';
$password = '';

$formData = [
  'email' => null,
  'password' => null,
];

if($_POST) {

    $formData['email'] = $_POST['email'];
    $formData['password'] = $_POST['password'];

  $user = $conn->fetchAssoc('SELECT * FROM client WHERE MailClient = :email',[
    'email' => $formData['email'],
  ]);

  if (preg_match("/" . $formData['password'] . "/","/" . $user['MdpClient'] . "/")) {
    $session = $user;
    // @toDo fermer la zoombox
    header('Location: index.php');
    exit();
  } else {
    $errors['password'] = 'Email ou mot de passe incorrect';
  }
}

echo $twig->render('identifier.html.twig', [
    // transmission de données au template
    'errors' => $errors,
    'formData' => $formData,
    'email'=> $email,
    'password' => $password,
]);