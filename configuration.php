<?php

/*
** Database configuration
** Developement environement only.
** Change this in the production environement
*/
define('DATABASE_LOCATION', '127.0.0.1');
define('DATABASE_NAME', 'cesistage');
define('DATABASE_USER', 'cesi');
define('DATABASE_PASSWORD', 'CesiPassWord');

define(
	'DATABASE_URL',
	'mysql:hostname=' . DATABASE_LOCATION . ';dbname=' . DATABASE_NAME
);

/*
** SMTP Conf for sending mails
** These value are here for testing purpose only.
** Please use a real SMTP server for production usage
*/
define('SMTP_SERVER', 'localhost');
define('SMTP_PORT', '1025');
define('SMTP_USERNAME', 'None');
define('SMTP_PASSWORD', 'None');
define('SMTP_SENDER', ['no-reply@serdaigle.eu' => 'Serdaigle System']);

/*
** Password hash and secret tokens generation
** Please take this seriousely.
** This is the security of our users
*/
// This value should be changed
define('SECRET', 'dhzwn8B/vpx12L69dYBPh1rdxwLHrzbryQCveeTUKTy4xAlx4hTpBg==');
// 5 000 seems to be the minimal but 10 000 is preffered
define('HASH_ITERATIONS', 10000);
