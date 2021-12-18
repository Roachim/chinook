<?php include_once "db.php";
//implement whole CRUD
// header('Content-Type: application/json');
// header('Accept-version: v1');
        //SQL
        //Prepare statement, bind and execute
        //cut connection
class Artist{
    //properties
    private $artistsId;
    private $name;
    //constructor
    
    //methods
    //getAllMethod
    public function GetAll(){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');   
        }
        //SQL
        $query = <<<'SQL'
            SELECT * FROM artist
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->execute();
        //create query result
        //$result = mysqli_query($con, $query);
        $result = $stmt->get_result();
        //populate the list from result
        // custom name => database id
        $list = [];
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
                "ArtistId" => htmlspecialchars($row['ArtistId']) , 
                "Name" => htmlspecialchars($row['Name'])
            );
        }
        

        return $list;
    }
    public function Get($id){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');   
        }
        //SQL
        $query = <<<'SQL'
            SELECT * FROM artist
            WHERE ArtistId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        
        //populate the list from result
        // custom name => database id
        $return =null;
        
        $return = array(
            "ArtistId" => $row['ArtistId'] , 
            "Name" => htmlspecialchars($row['Name'])
        );
        

        return $return;
    }
    // = array of values?
    public function Create($name){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO artist (Name)
            VALUES (?)
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $name);
        $status = $stmt->execute();
        if(!$status || $con->affected_rows < 1){
            return false;
        } else{
            return true;
        }
        

    }
    public function Update($artistId ,$name){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            UPDATE artist
            SET Name = ?
            WHERE ArtistId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("si", $name, $artistId);
        $stmt->execute();
        //cut connection

        return true;
    
    }
    public function Delete($artistId){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //prepare statement
        $query = <<<'SQL'
        DELETE FROM artist
        WHERE ArtistId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $artistId);
        $status = $stmt->execute();
        if(!$status || $con->affected_rows < 1){
            return false;
        }else{
            return true;
        }
    }
    function IntegrityCheck($artistId) {
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        // SQL
        $query = <<<'SQL'
            SELECT AlbumId 
            FROM album
            WHERE ArtistId = ?;
        SQL;
        //prepare, bind, execute
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $artistId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //check amount
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
                "AlbumId" => $row['AlbumId']
                );
        }
        if(empty($list)){
            return true;
        }
        return false;
    }
}

?>