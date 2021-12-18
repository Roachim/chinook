<?php

use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Stmt\Foreach_;

include_once "db.php";
include_once "track.php";

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
        $con->autocommit(false);
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
            //why is this one empty=???
            //it woks!!! get current date tiem to insert into invoice
            $invoiceDate = date('Y-m-d H:i:s');

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
            $lastId = $con->insert_id;
            
            $track = new Track();
            //insert each invoiceLine with id of just inserted invoice id. Using each item sent in array.
            
            foreach ($itemArray as $trackId) {
                $invoiceId = $lastId;
                //lets make more mess
                $item = $track->get($trackId);
                $unitPrice = $item['UnitPrice'];
                
                //really want to count the actual amount. this will have to do for now. no time
                $quantity = 1;
                
                $query = <<<'SQL'
                INSERT INTO invoiceline (InvoiceId, TrackId, UnitPrice, Quantity)
                VALUES (?, ?, ?, ?)
                SQL;
                //Prepare statement, bind and execute
                $stmt = $con->prepare($query);
                //return 'InvoiceId: '.$invoiceId.'trakId: '. $trackId. 'UnitPrice: '.$unitPrice. 'Quantity: '.$quantity;
                $stmt->bind_param("iidi", $invoiceId, $trackId, $unitPrice, $quantity);
                $lineStatus = $stmt->execute();
                if(!$lineStatus || $con->affected_rows <1){
                    $con->rollback();
                    return false;
                }
            }
            
            $con->commit();
            return true;
        } catch (mysqli_sql_exception $exception) {
            $con->rollback();
            return $exception;
        }
    }
}


?>