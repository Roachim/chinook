<?php
require_once 'API/db.php';
use PHPUnit\Framework\TestCase;
class dbTest extends TestCase{

    public function testConnection(){
        //arrange
        $db = new DataBase();
        $con = $db->connect();
        //act
        //assert
        $this->assertNotNull($con, "The connection should be not null");
    }
}

?>