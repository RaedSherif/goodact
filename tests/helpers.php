<?php
if (!isset($GLOBALS['passed'])) {
    $GLOBALS['passed'] = 0;
 
    $GLOBALS['failed'] = 0;
}

function check(string $label, bool $condition): void
{
    if ($condition) {
        echo "[PASS] $label\n";
        $GLOBALS['passed']++;
    } else {
        echo "[FAIL] $label\n";
        $GLOBALS['failed']++;
    }
}
