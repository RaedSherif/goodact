<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/listingsManager.php';


$item = new BaseItem('Honey');



$title = $item->getDisplayTitle();




check("BaseItem returns plain title", $title === 'Honey');
