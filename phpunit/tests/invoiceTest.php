<?php
require_once 'API/invoice.php';
use PHPUnit\Framework\TestCase;
class invoiceTest extends TestCase{

    public function test_Create_True(){
        //arrange
        $invoice = new Invoice();

        $customerid = 1;
        $billingAddress = 'asdsaf';
        $billingCity = 'asfasdg';
        $billingState = 'asfa';
        $billingCountry = 'asfa';
        $billingPostal = 'asf';
        $total = 0.99;
        $itemArray = ["1","2","3"];
        
        //act
        $result = $invoice->Create($customerid,$billingAddress, $billingCity, $billingState, $billingCountry, $billingPostal, $total, $itemArray);
        //assert
        $this->assertTrue($result, "The result should be not null");
    }
    public function test_Create_False(){
        //arrange
        $invoice = new Invoice();

        $customerid = null;
        $billingAddress = 'asdsaf';
        $billingCity = 'asfasdg';
        $billingState = 'asfa';
        $billingCountry = 'asfa';
        $billingPostal = 'asf';
        $total = 0.99;
        $itemArray = ["1","2","3"];
        
        //act
        $result = $invoice->Create($customerid,$billingAddress, $billingCity, $billingState, $billingCountry, $billingPostal, $total, $itemArray);
        //assert
        $this->assertFalse($result, "The result should be null");
    }
}

?>