<?php
require_once 'API/album.php';
use PHPUnit\Framework\TestCase;

class albumTest extends TestCase{

     /**
         * Basic unit tests (one test case per method)
         */
        public function test_GetAll_IsArray() {
             // Arrange
            //$album = new Album();
            $mockAlbum  = $this->createMock(Database::class);
            $mockAlbum = [1, 'bigAlbum', 1];
            // Act           
            $result = $album->GetAll();                  
            // Assert                            
            $this->assertIsArray($result, "Result should be should be an array.");   
        }
        public function test_Get_NotNull() {
            // Arrange
           $album = new Album();
           // Act           
           $result = $album->Get(1);                  
           // Assert                            
           $this->assertNotNull($result, "Result should not be empty.");   
        }
        public function test_Get_Null() {
            // Arrange
           $album = new Album();
           // Act           
           $result = $album->Get(100000);                  
           // Assert                            
           $this->assertNull($result, "Result should be empty.");   
        }
        public function test_Create_True() {
            // Arrange
           $album = new Album();
           // Act           
           $result = $album->Create('forTest', 1);                  
           // Assert                            
           $this->assertTrue($result, "Result should return true.");   
        }
        public function test_Create_False() {
            // Arrange
           $album = new Album();
           // Act           
           $result = $album->Create('forTest', 'hello');                  
           // Assert                            
           $this->assertFalse($result, "Result should return False.");   
        }
        public function test_Delete_True() {
            // Arrange
           $album = new Album();
           // Act           
           $result = $album->Create('forTest', 'hello');                  
           // Assert                            
           $this->assertFalse($result, "Result should return False.");   
        }
    
    
}

?>