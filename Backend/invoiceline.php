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
    public function Create($name){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO track (Name)
            VALUES (?)
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'Artist created';

    }
}

?>