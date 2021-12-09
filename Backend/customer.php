<?php include_once "db.php";

class Customer{
    //properties
    private $customerId;
    private $firstname;
    private $lastname;
    private $password;
    private $company;
    private $address;
    private $city;
    private $state;
    private $country;
    private $postalCode;
    private $phone;
    private $fax;
    private $email;
    //constructor
    //methods
    public function Get(){
        
    }
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
    public function Update($artistId ,$name){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO track (Name)
            VALUES (?)
            WHERE ArtistId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("si", $name, $artistId);
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'Artist updated';
    
    }
}


?>