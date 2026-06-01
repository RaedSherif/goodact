<?php

# RUN: C:\xampp\php\php.exe tests\run.php

require_once __DIR__ . '/helpers.php';

foreach (glob(__DIR__ . '/*Test.php') as $file) {
    require_once $file;
}

echo "Passed: " . $GLOBALS['passed'] . "\n";
echo "Failed: " . $GLOBALS['failed'] . "\n";
