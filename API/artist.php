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
        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

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
        
        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

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
        $stmt->execute();
        //cut and return
        $db->cutConnection($con);
        return 'Artist deleted';
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
        if(count($row) == 0 || count($row) == null){
            return true;
        }
        return false;
    }
}

?>