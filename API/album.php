<?php include_once "db.php";
//implement whole CRUD
class Album{
    //properties
    private $almbumId;
    private $title;
    private $artistId;
    //constructor
    //methods
    //getAllMethod
    
    public function GetAll(){
        $db = new DataBase();
        $con = $db->connect();

        if (!$con) {
            die('Connection lost');
        }
        //array to return. retres = return result 
        //SQL
        $query = <<<'SQL'
        SELECT AlbumId, Title, a.Name FROM album al
        LEFT JOIN artist a ON a.ArtistId = al.ArtistId
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        //populate the return result
        // custom name => database id
        $list=[];
        while ($row = mysqli_fetch_array($result)) {

            $list[] = array(
            "AlbumId" => $row['AlbumId'],
            "Title" => htmlspecialchars($row['Title']), 
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
        SELECT AlbumId, Title, a.Name FROM album al
        LEFT JOIN artist a ON a.ArtistId = al.ArtistId
        WHERE AlbumId = ?
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
        if(!empty($row)){
            $return = array(
                "AlbumId" => htmlspecialchars($row['AlbumId']),
                "Title" => htmlspecialchars($row['Title']), 
                "Name" => htmlspecialchars($row['Name'])
            );
        }
        
        
        
        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

        return $return;
    }
    public function Create($title, $artistId){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO album (Title, ArtistId)
            VALUES (?, ?)
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("si", $title, $artistId);
        $status = $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        if($status){
            return true;
        } else{
            return false;
        }

    }
    public function Update($albumId ,$title, $artistId){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            UPDATE album
            SET Title = ?, ArtistId = ?
            WHERE AlbumId = ?;
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("sii", $title, $artistId, $albumId);
        $status = $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        if(!$status || $con->affected_rows < 1){
            return false;
        } else{
            return true;
        }
        
    
    }
    public function Delete($albumId){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //first, remove albumId from associated tracks
        $query = <<<'SQL'
            UPDATE track
            SET AlbumId = NULL
            WHERE AlbumId = ?;
        SQL;
        //prepare, bind, execute
        $prepared = $stmt = $con->prepare($query);
        if(!$prepared){
            return false;
        }
        $stmt->bind_param('i', $albumId);
        $stmt->execute();
        //Now delete the actual track
        //prepare statement
        $query = <<<'SQL'
        DELETE FROM album
        WHERE AlbumId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $albumId);
        $deleted = $stmt->execute();
        //cut and return
        $message = '';
        if(!$deleted || $con->affected_rows < 1){
            $message =false;
        }else {
            $message = true;
        }
        $db->cutConnection($con);
        return $message;
    }
    
}


?>