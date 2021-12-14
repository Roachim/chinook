<?php include_once "db.php";

class Admin{
    //properties
    //constructor
    //methods
    function validate($password) {
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        // SQL
        $query = <<<'SQL'
            SELECT Password
            FROM Admin
        SQL;
        //prepare, bind, execute
        $stmt = $con->prepare($query);
        
        //$stmt->bind_param("s", $password);
        
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $this->password = $row['Password'];

        // hash check password
        if(!password_verify($password, $this->password)){
            return false;
        }
        return true;
    }
}




?>