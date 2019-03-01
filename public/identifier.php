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

$errors = [];
$email ='';
$password = '';
$closeZoombox = false;

$formData = [
  'email' => null,
  'password' => null,
];

if($_POST) {
  if(empty($_POST['email'])) {
    $errors['email'] = 'Vous devez renseigner ce champ';
  } else {
    $formData['email'] = $_POST['email'];
  }

  if(empty($_POST['password'])) {
    $errors['password'] = 'Vous devez renseigner ce champ';
  } else {
    $formData['password'] = $_POST['password'];
  }

  $userPart = $conn->fetchAssoc('SELECT * FROM particulier P JOIN client C ON C.NumClient=P.CodePart WHERE MailClient = :email',[
    'email' => $formData['email'],
  ]);
  $userPro = $conn->fetchAssoc('SELECT * FROM professionnel P JOIN client C ON C.NumClient=P.CodePro WHERE MailClient = :email',[
    'email' => $formData['email'],
  ]);

  if(!($errors)) {

    if(preg_match("/" . password_hash($formData['password']) . "/","/" . password_hash($userPart['MdpClient'], PASSWORD_BCRYPT) . "/")
    || preg_match("/" . password_hash($formData['password']) . "/","/" . password_hash($userPro['MdpClient'], PASSWORD_BCRYPT) )) {
      session_start();
      if($userPart['MdpClient']) {
      $_SESSION['user'] = $userPart;
      } elseif($userPro['MdpClient']) {
      $_SESSION['user'] = $userPro;
      } else {
      $errors['password'] = 'Email ou mot de passe incorrect';
      }
      $closeZoombox = true;
    }

  }
}

echo $twig->render('identifier.html.twig', [
    'errors' => $errors,
    'formData' => $formData,
    'email'=> $email,
    'password' => $password,
    'closeZoombox' => $closeZoombox,
]);
