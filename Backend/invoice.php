<?php include_once "db.php";

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
    public function Create($customerId, $invoiceDate, $billingAddress, $billingCity, $billingState, $billingCountry, $billingPostal, $total){
        $db = new DataBase();
        $con = $db->connect();
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
        //cut connection
        
        $db->cutConnection($con);
        return 'Invoice created';

    }
}


?>