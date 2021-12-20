<?php
require_once 'API/track.php';
use PHPUnit\Framework\TestCase;
class trackTest extends TestCase{

    public function test_GetAll_IsArray() {
        // Arrange
       $track = new Track();
       // Act           
       $result = $track->GetAll();                  
       // Assert                            
       $this->assertIsArray($result, "Result should be should be an array.");   
   }
   public function test_Get_NotNull() {
       // Arrange
       $track = new Track();
      // Act           
      $result = $track->Get(1);                  
      // Assert                            
      $this->assertNotNull($result, "Result should not be empty.");   
   }
   public function test_Create_True() {
       // Arrange
       $track = new Track();
        $array = ['testName', 1, 1, 1, 'theTest', 55555, 60000, 0.99];
      // Act           
      $result = $track->Create($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6], $array[7]);                  
      // Assert                            
      $this->assertTrue($result, "Result should return true.");   
   }
   public function test_Create_False() {
        // Arrange
        $track = new Track();
        $array = ['', 'hello There', 'ObiWan here', 'This test chould fail successfully now', 'theTest', 55555, 60000, 0.99];
        // Act           
        $result = $track->Create($array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6], $array[7]);                  
        // Assert                            
        $this->assertFalse($result, "Result should return true.");   
    }
   
   public function test_Update_True() {
       // Arrange
       $track = new Track();
       $id = 1;
       $array = ['testName', 1, 1, 1, 'theTest', 55555, 60000, 0.99];
      // Act           
      $result = $track->Update($id, $array[0], $array[1], $array[2], $array[3], $array[4], $array[5], $array[6], $array[7]);                  
      // Assert                            
      $this->assertTrue($result, "Result should return true.");   
   }
   public function test_Delete_True() {
       // Arrange
       $track = new Track();
      $id = 3505;
      // Act           
      $result = $track->Delete($id);
      // Assert                            
      $this->assertTrue($result, "Result should return True");   
   }
   public function test_Delete_False() {
       // Arrange
       $track = new Track();
      $id = 1000000;
      // Act           
      $result = $track->Delete($id);                  
      // Assert                            
      $this->assertFalse($result, "Result should return False.");   
   }
   public function test_IntegrityCheck_False() {
        // Arrange
        $track = new Track();
        $id = 1;
        // Act           
        $result = $track->IntegrityCheck($id);                  
        // Assert                            
        $this->assertFalse($result, "Result should return False.");   
    }
    public function test_IntegrityCheck_True() {
        // Arrange
        $track = new Track();
        $id = 1000000;
        // Act           
        $result = $track->IntegrityCheck($id);                  
        // Assert                            
        $this->assertTrue($result, "Result should return true.");   
    }
}

?>