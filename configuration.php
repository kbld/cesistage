<?php

define('DATABASE_LOCATION', '127.0.0.1');
define('DATABASE_NAME', 'cesistage');
define('DATABASE_USER', 'cesi');
define('DATABASE_PASSWORD', 'CesiPassWord');

define(
	'DATABASE_URL',
	'mysql:hostname=' . DATABASE_LOCATION . ';dbname=' . DATABASE_NAME
);

// This value should be changed
define('SECRET', 'dhzwn8B/vpx12L69dYBPh1rdxwLHrzbryQCveeTUKTy4xAlx4hTpBg==');
// 5 000 seems to be the minimal but 10 000 is preffered
define('HASH_ITERATIONS', 10000);
