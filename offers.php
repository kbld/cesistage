<?php
require_once 'database.php';
require_once 'utils.php';

if ((isset($_GET['search']) && $_GET['search'] != '') && (isset($_GET['limit']) && $_GET['limit'] != '')) {
	$search = CleanInput($_GET['search']);
	$limit = CleanInput($_GET['limit']);
	$offers_number = GetNumberOfOffers();
	$offers = SearchOffers($search, $limit);

	Render('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers['request'], 'match' => $offers['affected']]);
} elseif (isset($_GET['search']) && $_GET['search'] != '') {
	$search = CleanInput($_GET['search']);
	$offers_number = GetNumberOfOffers();
	$offers = SearchOffers($search);

	Render('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers['request'], 'match' => $offers['affected']]);
} elseif (isset($_GET['limit']) && $_GET['limit'] != '') {
	$limit = CleanInput($_GET['limit']);
	$offers_number = GetNumberOfOffers();
	$offers = GetOffers($limit);

	Render('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers['request'], 'match' => $offers['affected']]);
} else {
	$offers_number = GetNumberOfOffers();
	$offers = GetOffers();

	Rrender('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers['request'], 'match' => $offers['affected']]);
}
