<?php

declare(strict_types = 1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

require APP_PATH.'/App.php';

$transacrion_files = read_files(FILES_PATH);

$transaction_files = parsed_files($transacrion_files);

$totals = calculateTotals($transaction_files);

require VIEWS_PATH.'/transactions.php';
/* YOUR CODE (Instructions in README.md) */
