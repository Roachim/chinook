<?php include_once "db.php";

class InvoiceLine{
    //properties
    private $invoiceLineId;
    private $invoiceId;
    private $trackId;
    private $unitPrice;
    private $quantity;
    //contructor
    function __contructor(){
        
    }
    //methods
    public function Create($invoiceId, $trackId, $unitPrice, $quantity){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO invoice (InvoiceId, TrackId, UnitPrice, Quantity)
            VALUES (?, ?, ?, ?)
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);

        $stmt->bind_param("iidi", $invoiceId, $trackId, $unitPrice, $quantity);
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'InvoiceLine created';

    }
}

?>