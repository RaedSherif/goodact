<?php
/**
 * Simple unit tests for goodact (Sommerville Ch.8 style).
 *
 * Run:  C:\xampp\php\php.exe tests\tests.php
 *
 * Each test = setup -> call -> assert.
 */

require_once __DIR__ . '/../models/listingsManager.php';
require_once __DIR__ . '/../models/BaseMenu.php';

$passed = 0;
$failed = 0;

function check(string $label, bool $condition): void
{
    global $passed, $failed;
    if ($condition) {
        echo "[PASS] $label\n";
        $passed++;
    } else {
        echo "[FAIL] $label\n";
        $failed++;
    }
}


// ===== SortAscending =====

// Test 1: empty sequence (guideline: zero-length)
$out = (new SortAscending())->sortData([]);
check("SortAscending empty -> empty", $out === []);

// Test 2: single element (guideline: single-value)
$out = (new SortAscending())->sortData([['title' => 'A']]);
check("SortAscending single -> same", count($out) === 1 && $out[0]['title'] === 'A');

// Test 3: normal partition - sorts alphabetically
$in  = [['title' => 'Mango'], ['title' => 'Apple'], ['title' => 'Zebra']];
$out = (new SortAscending())->sortData($in);
check("SortAscending orders A..Z",
    $out[0]['title'] === 'Apple' && $out[2]['title'] === 'Zebra');


// ===== SortDescending =====

// Test 4: reverse order
$in  = [['title' => 'Apple'], ['title' => 'Mango'], ['title' => 'Zebra']];
$out = (new SortDescending())->sortData($in);
check("SortDescending orders Z..A",
    $out[0]['title'] === 'Zebra' && $out[2]['title'] === 'Apple');

// Test 5: duplicates partition
$out = (new SortDescending())->sortData([['title' => 'X'], ['title' => 'X']]);
check("SortDescending duplicates kept", count($out) === 2);


// ===== BaseItem =====

// Test 6: returns title unchanged
$item = new BaseItem('Honey');
check("BaseItem returns plain title", $item->getDisplayTitle() === 'Honey');


// ===== PremiumBadgeDecorator =====

// Test 7: appends Premium badge text
$decorated = new PremiumBadgeDecorator(new BaseItem('Honey'));
$out = $decorated->getDisplayTitle();
check("PremiumBadge contains original title", str_contains($out, 'Honey'));
check("PremiumBadge contains [Premium]",       str_contains($out, '[Premium]'));

// Test 8: nested decorator (defect/edge case)
$double = new PremiumBadgeDecorator(new PremiumBadgeDecorator(new BaseItem('X')));
check("PremiumBadge nests -> two badges",
    substr_count($double->getDisplayTitle(), '[Premium]') === 2);


// ===== BaseMenu =====

// Test 9: base menu returns Profile + Logout
$items = (new BaseMenu())->getMenuItems();
$names = array_column($items, 'name');
check("BaseMenu has My Profile", in_array('My Profile', $names, true));
check("BaseMenu has Logout",     in_array('Logout',     $names, true));
check("BaseMenu size = 2",       count($items) === 2);


// ===== Summary =====

echo "\n----------------------------------------\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";
exit($failed === 0 ? 0 : 1);
