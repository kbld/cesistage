<?php
session_start();
require_once 'vendor/autoload.php';
require 'database.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, []);

$numbers_of_offers = GetNumberOfOffers();

echo $twig->render('main.twig', ['offers' => $numbers_of_offers]);
