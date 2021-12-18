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
    public function Create($customerId, $billingAddress, $billingCity, $billingState, $billingCountry, $billingPostalCode, $total, $itemArray){
        $db = new DataBase();
        $con = $db->connect();
        $con->begin_transaction();
        try{
            if (!$con) {
                die('Connection error');
            } 
            //SQL
            $query = <<<'SQL'
                INSERT INTO invoice (CustomerId, InvoiceDate, BillingAddress, BillingCity, BillingState, BillingCountry, BillingPostalCode, Total)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            SQL;
            //set time to denmark and get dateTime
            date_default_timezone_set('Europe/Copenhagen');
            $invoiceDate = date('m/d/Y h:i:s a', time());

            //Prepare statement, bind and execute
            $preparetatus = $stmt = $con->prepare($query);
            if(!$preparetatus){
                return $con->error;
            }
            $bindStatus = $stmt->bind_param("issssssd", $customerId, $invoiceDate, $billingAddress, $billingCity, $billingState, $billingCountry, $billingPostalCode, $total);
            if(!$bindStatus){
                return $con->error_list;
            }
            $stmt->execute();
            $invoiceId = $con->insert_id;
            //insert each invoiceLine with id of just inserte invoice id. Using each item sent in array.
            foreach ($itemArray as $trackId) {
                global $invoiceId;
                $query = <<<'SQL'
                INSERT INTO invoice (InvoiceId, TrackId, UnitPrice, Quantity)
                VALUES (?, ?, ?, ?)
                SQL;
                //Prepare statement, bind and execute
                $stmt = $con->prepare($query);

                $stmt->bind_param("iidi", $invoiceId, $trackId, $unitPrice, $quantity);
                $stmt->execute();
            }
            $con->commit();
            return true;
        } catch (mysqli_sql_exception $exception) {
            $$con->rollback();
            return false;
        }
    }
}


?>