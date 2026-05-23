<?php
require_once 'iAuth.php';

class AuthManager {
    private $operation;

    public function __construct(iAuth $operation) {
        $this->operation = $operation;
    }

    public function process($data) {
        return $this->operation->execute($data);
    }
}
?>