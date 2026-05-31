<?php

require_once __DIR__ . '/helpers.php';

foreach (glob(__DIR__ . '/*Test.php') as $file) {
    require_once $file;
}

echo "\n----------------------------------------\n";
echo "Passed: " . $GLOBALS['passed'] . "\n";
echo "Failed: " . $GLOBALS['failed'] . "\n";
exit($GLOBALS['failed'] === 0 ? 0 : 1);

//To Use Unit Tests Run This Command:  C:\xampp\php\php.exe tests\run.php
