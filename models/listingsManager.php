<?php
require_once __DIR__ . '/../interfaces/ISort.php';
require_once __DIR__ . '/../interfaces/IItem.php';

class SortAscending implements ISort {
    public function sortData(array $data): array {
        usort($data, fn($a, $b) => strcmp($a['title'], $b['title']));
        return $data;
    }
}

class SortDescending implements ISort {
    public function sortData(array $data): array {
        usort($data, fn($a, $b) => strcmp($b['title'], $a['title']));
        return $data;
    }
}

class BaseItem implements IItem {
    private $title;
    public function __construct($title) { $this->title = $title; }
    public function getDisplayTitle(): string { return $this->title; }
}

class PremiumBadgeDecorator implements IItem {
    private $item;
    public function __construct(IItem $item) { $this->item = $item; }
    public function getDisplayTitle(): string {
        return $this->item->getDisplayTitle() . "
         ⭐ <span style='font-size:12px; color:gold;'>[Premium]</span>"; 
    }
}
?>