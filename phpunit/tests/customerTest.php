<?php
require_once 'API/customer.php';
use PHPUnit\Framework\TestCase;
class customerTest extends TestCase{

    public function test_GetAll_IsArray() {
        // Arrange
       $customer = new Customer();
       // Act           
       $result = $customer->GetAll();                  
       // Assert                            
       $this->assertIsArray($result, "Result should be should be an array.");   
   }
   public function test_Get_NotNull() {
       // Arrange
       $customer = new Customer();
      // Act           
      $result = $customer->Get(1);                  
      // Assert                            
      $this->assertNotNull($result, "Result should not be empty.");   
   }
   public function test_Create_True() {
       // Arrange
       $customer = new Customer();
      $array = ['MadeByTest', 'forTest', 'forTest', 'email', ''];
      // Act           
      $result = $customer->Create($array[0], $array[1], $array[2], $array[0], $array[0], $array[0], $array[0], $array[0], $array[0], $array[0], $array[0], $array[3]);                  
      // Assert                            
      $this->assertTrue($result, "Result should return true.");   
   }
   public function test_Create_False() {
    // Arrange
    $customer = new Customer();
   $array = ['MadeByTest', 'forTest', 'forTest', 'email', ''];
   // Act           
   $result = $customer->Create($array[4], $array[4], $array[4], $array[4], $array[4], $array[4], $array[4], $array[4], $array[4], $array[4], $array[4], $array[4]);                  
   // Assert                            
   $this->assertTrue($result, "Result should return true.");   
}
   
   public function test_Update_True() {
       // Arrange
       $customer = new Customer();
       $customerId = 1;
       $firstName = "testName";
       $lastName = "testLastName";
       $company = "testcompany";
       $address = "testAddress";
       $city = "testCity";
       $state = "testState";
       $country = "testCountry";
       $postalCode = "testPostal";
       $phone = "testPhone";
       $fax = "testFax";
       $email = "luisg@embraer.com";
       $password = "";
       $newPassord = "";
      // Act           
      $result = $customer->Update($customerId, $firstName, $lastName, $company, $address, $city, $state, $country, $postalCode, $phone, $fax, $email, $password, $newPassord);                  
      // Assert                            
      $this->assertTrue($result, "Result should return true.");   
   }
   
}

?>