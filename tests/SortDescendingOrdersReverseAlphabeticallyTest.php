<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/listingsManager.php';


$input = [
    ['title' => 'Apple'],
    ['title' => 'Mango'],
    ['title' => 'Zebra'],
];


$output = (new SortDescending())->sortData($input);





check(
    "SortDescending orders titles Z..A",
    $output[0]['title'] === 'Zebra'
    && $output[1]['title'] === 'Mango'
    && $output[2]['title'] === 'Apple'
);
