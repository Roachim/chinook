<?php

use PhpParser\Node\Stmt\Foreach_;

include_once "db.php";

class Invoice{
    //properties
    private $invoiceId;
    private $customerId;
    private $invoiceDate;
    private $bilingAddress;
    private $billingCity;
    private $billingState;
    private $billingCountry;
    private $billingPostalCode;
    private $total;
    //constructor
    //methods
    public function Create($customerId, $invoiceDate, $billingAddress, $billingCity, $billingState, $billingCountry, $billingPostal, $total, $itemArray){
        $db = new DataBase();
        $con = $db->connect();
        $con->begin_transaction();
        try{
            if (!$con) {
                die('Connection error');
            } 
            //SQL
            $query = <<<'SQL'
                INSERT INTO invoice (CustomerId, InvoiceDate, BillingAddress, BillingCity, BillingState, BillingCountry, BillingPostal, Total)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            SQL;
            //Prepare statement, bind and execute
            $stmt = $con->prepare($query);
            $stmt->bind_param("issssssd", $customerId, $invoiceDate, $billingAddress, $billingCity, $billingState, $billingCountry, $billingPostal, $total);
            $stmt->execute();
            $invoiceId = $con->insert_id;
            foreach ($itemArray as $id) {
                global $invoiceId;
                $query = <<<'SQL'
                INSERT INTO invoice (InvoiceId, TrackId, UnitPrice, Quantity)
                VALUES (?, ?, ?, ?)
                SQL;
                //Prepare statement, bind and execute
                $stmt = $con->prepare($query);

                $stmt->bind_param("iidi", $invoiceId, $trackId, $unitPrice, $quantity);
                $stmt->execute();
                
                $con->commit();
            }
        
            return true;
        } catch (mysqli_sql_exception $exception) {
            $$con->rollback();
            return false;
        }
    }
}


?>