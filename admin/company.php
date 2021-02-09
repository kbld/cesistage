<?php
require_once('../utils.php');
require_once('../database.php');

$company = GetCompaniesList();

Render('edit_company.twig', ['company' => $company]);
