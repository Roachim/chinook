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
            $result = $album->GetAll();                  
            // Assert                            
            $this->assertIsArray($result);   
        }
    //     public function GetAllReturnsNonEmpty() {
    //         // Arrange
    //        $album = new Album();
    //        // Act                     
    //        $result = $album->GetAll();                  
    //        // Assert                            
    //        $this->assertIsArray(gettype($expect), gettype($result));   
    //    }
}

?>