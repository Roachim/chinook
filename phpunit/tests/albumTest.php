<?php
require_once 'API/album.php';
use PHPUnit\Framework\TestCase;

class albumTest extends TestCase{

        public function test_GetAll_IsArray() {
             // Arrange
            $album = new Album();
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
           $title = "testMade";
           $artistId = 1;
           // Act           
           $result = $album->Create($title, $artistId);                  
           // Assert                            
           $this->assertTrue($result, "Result should return true.");   
        }
        public function test_Create_False() {
            // Arrange
           $album = new Album();
           $title = "testMade";
           $artistId = 10000000;
           // Act           
           $result = $album->Create($title, $artistId);                  
           // Assert                            
           $this->assertFalse($result, "Result should return False.");   
        }
        public function test_Update_True() {
            // Arrange
           $album = new Album();
           $albumId = 3;
           $title = "testMade";
           $artistId = 3;
           // Act           
           $result = $album->Update($albumId, $title, $artistId);                  
           // Assert                            
           $this->assertTrue($result, "Result should return true.");   
        }
        public function test_Delete_True() {
            // Arrange
           $album = new Album();
           $id = count($album->GetAll());
           // Act           
           $result = $album->Delete($id);
           // Assert                            
           $this->assertTrue($result, "Result should return False.");   
        }
        public function test_Delete_False() {
            // Arrange
           $album = new Album();
           $id = 1000000;
           // Act           
           $result = $album->Delete($id);                  
           // Assert                            
           $this->assertFalse($result, "Result should return False.");   
        }
    
    
}

?>