<?php
require_once 'API/album.php';
use PHPUnit\Framework\TestCase;

class albumTest extends TestCase{

     /**
         * Basic unit tests (one test case per method)
         */
        public function GetAllReturnsArray() {
             // Arrange
            $album = new Album();
            // Act
            $expect = [];                            
            $result = $album->GetAll();                  
            // Assert                            
            $this->assertEquals(gettype($expect), gettype($result), "The result should be $expect");   
        }
}

?>