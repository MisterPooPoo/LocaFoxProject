<?php

require __DIR__.'/../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');

$twig = new Twig_Environment($loader, [
    'debug' => true,
    'strict_variables' => true,
]);

$twig->addExtension(new Twig_Extension_Debug());

$closeZoombox = true;
session_start();
session_destroy();

echo $twig->render('logout.html.twig', [
  'closeZoombox' => $closeZoombox,
]);
