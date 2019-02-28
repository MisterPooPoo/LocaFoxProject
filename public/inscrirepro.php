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

$confirmPassword = '';
$lengthPassword = '';
$numClient = '';
$name = '';
$siret = '';
$email = '';
$tel = '';
$password = '';
$address = '';
$cp = '';
$city = '';
$closeZoombox = false;

if ($_POST) {
  // vérifier la validité des données

  if (empty($_POST['name'])) {
    $errors['name'] =  "Vous devez renseigner ce champ";
  } else {
    $name = $_POST['name'];
  }

  if (empty($_POST['siret'])) {
    $errors['siret'] =  "Vous devez renseigner ce champ";
  } else {
    $siret = $_POST['siret'];
  }

  if (empty($_POST['email'])) {
    $errors['email'] =  "Vous devez renseigner ce champ";
  } else {
    $email = $_POST['email'];
  }

  if (empty($_POST['tel'])) {
    $errors['tel'] =  "Vous devez renseigner ce champ";
  } else {
    $tel = $_POST['tel'];
  }

  if (empty($_POST['password'])) {
    $errors['password'] =  "Vous devez renseigner ce champ";
  } else {
    if (!(strlen($_POST['password']) == 8)) {
      $errors['lengthPassword'] = "Le mot de passe doit contenir 8 caractères";
    } elseif (preg_match( "/" . $_POST['password'] . "/", "/" . $_POST['confirmPassword'] . "/")) {
      $password = $_POST['password'];
    } else {
      $errors['confirmPassword'] = "Le mot de passe ne correspond pas";
    }
  }

  if (empty($_POST['cp'])) {
    $errors['cp'] =  "Vous devez renseigner ce champ";
  } else {
    $cp = $_POST['cp'];
  }
  if (empty($_POST['city'])) {
    $errors['city'] =  "Vous devez renseigner ce champ";
  } else {
    $city = $_POST['city'];
  }
  if (empty($_POST['address'])) {
    $errors['address'] =  "Vous devez renseigner ce champ";
  } else {
    $address = $_POST['address'];
  }

  if (!($errors)) {
    $nbClientSql = 'SELECT MAX(NumClient) FROM client';
    $nbClient = $conn->fetchColumn($nbClientSql);
    $numClient = $nbClient+1;

    $clientsSql = $conn->prepare('INSERT INTO client(NumClient, NomClient, AdClient, VilleClient, CPClient, TelClient, MailClient, MdpClient)
    VALUES(:numClient, :name, :address, :city, :cp, :tel, :email, :password)');

    $clientsSql->execute(array(
      'numClient' => $numClient,
      'name' => $name,
      'address' => $address,
      'city' => $city,
      'cp' => $cp,
      'tel' => $tel,
      'email' => $email,
      'password' => $password,
    ));

    $clientpro = $conn->prepare('INSERT INTO professionnel(CodePro, Siret) VALUES(:numClient, :siret)');
    $clientpro-> execute(array(
      'numClient' => $numClient,
      'siret' => $siret,
    ));
    $closeZoombox = true;
  }
}

echo $twig->render('inscrirepro.html.twig', [
  // transmission de données au template
  'confirmPassword' => $confirmPassword,
  'lengthPassword'=> $lengthPassword,
  'numClient' => $numClient,
  'name' => $name,
  'siret' => $siret,
  'email' => $email,
  'tel' => $tel,
  'password' => $password,
  'address' => $address,
  'cp' => $cp,
  'city' => $city,
  'errors' => $errors,
  'closeZoombox' => $closeZoombox,
]);
