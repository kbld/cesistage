<?php
require_once 'database.php';
require_once 'utils.php';

if ((isset($_GET['search']) && $_GET['search'] != '') && (isset($_GET['limit']) && $_GET['limit'] != '')) {
	$search = CleanInput($_GET['search']);
	$limit = CleanInput($_GET['limit']);
	$offers_number = GetNumberOfOffers();
	$offers = SearchOffers($search, $limit);

	Render('search.twig', ['offers_number' => $offers_number, 'offers' => $offers['request'] ?? 0, 'match' => $offers['affected'] ?? 0]);
} elseif (isset($_GET['search']) && $_GET['search'] != '') {
	$search = CleanInput($_GET['search']);
	$offers_number = GetNumberOfOffers();
	$offers = SearchOffers($search);

	Render('search.twig', ['offers_number' => $offers_number, 'offers' => $offers['request'] ?? 0, 'match' => $offers['affected'] ?? 0]);
} elseif (isset($_GET['limit']) && $_GET['limit'] != '') {
	$limit = CleanInput($_GET['limit']);
	$offers_number = GetNumberOfOffers();
	$offers = GetOffers($limit);

	Render('search.twig', ['offers_number' => $offers_number, 'offers' => $offers ?? 0, 'match' => 1]);
} else {
	$offers_number = GetNumberOfOffers();
	$offers = GetOffers();

	Render('search.twig', ['offers_number' => $offers_number, 'offers' => $offers ?? 0, 'match' => 1]);
}
