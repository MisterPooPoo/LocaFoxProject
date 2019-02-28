<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';


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

$closeZoombox = true;
session_start();
session_destroy();

echo $twig->render('logout.html.twig', [
  'closeZoombox' => $closeZoombox,
]);
