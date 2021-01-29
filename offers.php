<?php
session_start();
require_once 'vendor/autoload.php';
require 'database.php';
require 'utils.php';

$loader = new \Twig\Loader\FilesystemLoader('views');
$twig = new \Twig\Environment($loader, []);

if ((isset($_GET['search']) && $_GET['search'] != '') && (isset($_GET['limit']) && $_GET['limit'] != '')) {
	$search = CleanInput($_GET['search']);
	$limit = CleanInput($_GET['limit']);
	$offers_number = GetNumberOfOffers();
	$offers = SearchOffers($search, $limit);

	echo $twig->render('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers]);
} elseif (isset($_GET['search']) && $_GET['search'] != '') {
	$search = CleanInput($_GET['search']);
	$offers = SearchOffers($search);

	echo $twig->render('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers]);
} elseif (isset($_GET['limit']) && $_GET['limit'] != '') {
	$limit = CleanInput($_GET['limit']);
	$offers_number = GetNumberOfOffers();
	$offers = GetOffers($limit);

	echo $twig->render('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers]);
} else {
	$offers_number = GetNumberOfOffers();
	$offers = GetOffers();

	echo $twig->render('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers]);
}
