<?php
require_once 'database.php';
require_once 'utils.php';

$offers_number = GetNumberOfOffers();
$offers = GetOffers();

Render('offers.twig', ['offers_number' => $offers_number, 'offers' => $offers['request'] ?? 0, 'match' => $offers['affected'] ?? 0]);
