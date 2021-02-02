<?php
require_once 'database.php';
require_once 'utils.php';

$numbers_of_offers = GetNumberOfOffers();

Render('index.twig', ['offers' => $numbers_of_offers]);
