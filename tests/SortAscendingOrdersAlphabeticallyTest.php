<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/listingsManager.php';

$input = [
    ['title' => 'Mango'],
    ['title' => 'Apple'],
    ['title' => 'Zebra'],
];

$output = (new SortAscending())->sortData($input);

check(
    "SortAscending orders titles A..Z",
    $output[0]['title'] === 'Apple'
    && $output[1]['title'] === 'Mango'
    && $output[2]['title'] === 'Zebra'
);
