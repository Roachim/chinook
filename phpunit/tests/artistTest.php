<?php
require_once 'API/artist.php';
use PHPUnit\Framework\TestCase;
class artistTest extends TestCase{

    public function test_GetAll_IsArray() {
        // Arrange
       $artist = new Artist();
       // Act           
       $result = $artist->GetAll();                  
       // Assert                            
       $this->assertIsArray($result, "Result should be should be an array.");   
   }
   public function test_Get_NotNull() {
       // Arrange
       $artist = new Artist();
      // Act           
      $result = $artist->Get(1);                  
      // Assert                            
      $this->assertNotNull($result, "Result should not be empty.");   
   }
   public function test_Get_Null() {
       // Arrange
       $artist = new Artist();
      // Act           
      $result = $artist->Get(100000);                  
      // Assert                            
      $this->assertNull($result, "Result should be empty.");   
   }
   public function test_Create_True() {
       // Arrange
       $artist = new Artist();
      $array = ['MadeByTest'];
      // Act           
      $result = $artist->Create($array[0]);                  
      // Assert                            
      $this->assertTrue($result, "Result should return true.");   
   }
   
   public function test_Update_True() {
       // Arrange
       $artist = new Artist();
      $artistId = 1;
      $name = "testName";
      // Act           
      $result = $artist->Update($artistId, $name);                  
      // Assert                            
      $this->assertTrue($result, "Result should return true.");   
   }
   public function test_Delete_True() {
       // Arrange
       $artist = new Artist();
      $id = count($artist->GetAll());
      // Act           
      $result = $artist->Delete($id);
      // Assert                            
      $this->assertTrue($result, "Result should return False.");   
   }
   public function test_Delete_False() {
       // Arrange
       $artist = new Artist();
      $id = 1000000;
      // Act           
      $result = $artist->Delete($id);                  
      // Assert                            
      $this->assertFalse($result, "Result should return False.");   
   }
   public function test_IntegrityCheck_False() {
        // Arrange
        $artist = new Artist();
        $id = 1;
        // Act           
        $result = $artist->IntegrityCheck($id);                  
        // Assert                            
        $this->assertFalse($result, "Result should return False.");   
    }
    public function test_IntegrityCheck_True() {
        // Arrange
        $artist = new Artist();
        $id = 1000000;
        // Act           
        $result = $artist->IntegrityCheck($id);                  
        // Assert                            
        $this->assertTrue($result, "Result should return true.");   
    }
}

?>