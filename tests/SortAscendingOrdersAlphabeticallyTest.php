<?php
/**
 * Test: SortAscending orders listings alphabetically by title.
 * Success scenario - normal multi-element input.
 */

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/listingsManager.php';

// setup
$input = [
    ['title' => 'Mango'],
    ['title' => 'Apple'],
    ['title' => 'Zebra'],
];

// call
$output = (new SortAscending())->sortData($input);

// assert
check(
    "SortAscending orders titles A..Z",
    $output[0]['title'] === 'Apple'
    && $output[1]['title'] === 'Mango'
    && $output[2]['title'] === 'Zebra'
);
