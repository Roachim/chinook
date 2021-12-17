<?php
require_once 'API/adminphp';
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertTrue;

class adminTest extends TestCase{

    public function testValidate() {
        //arrange
        $admin = new Admin();
        $password = 'admin';
        //act
        $result = $admin->validate($password);
        //assert
        $this->assertTrue($result, "Validation should return true.");
    }
}

?>