<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../models/listingsManager.php';

$decorated = new PremiumBadgeDecorator(new BaseItem('Honey'));

$title = $decorated->getDisplayTitle();

check(
    "PremiumBadgeDecorator appends [Premium] to title",
    str_contains($title, 'Honey') && str_contains($title, '[Premium]')
);
