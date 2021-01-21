<?php
require_once '/èvendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, [
    'cache' => '/path/to/compilation_cache',
]);
