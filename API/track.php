<?php include_once "db.php";
//implement whole CRUD
class Track{
    //properties
    private $trickId;
    private $albumId;
    private $mediaTypeId;
    private $genreId;
    private $composer;
    private $miliseconds;
    private $bytes;
    private $unitPrice;
    //constructor
    //methods
     //getAllMethod
     public function GetAll(){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        
        $query = <<<'SQL'
        SELECT TrackId, t.Name, AlbumId, mt.Name as MediaType, g.Name as Genre, Composer, Milliseconds, Bytes, UnitPrice FROM track t
        LEFT JOIN mediatype mt ON mt.MediaTypeId = t.MediaTypeId
        LEFT JOIN genre g ON g.GenreId = t.GenreId
        SQL;
        $stmt = $con->prepare($query);
            
        $stmt->execute();
        $result = $stmt->get_result();
        //array to return 
        $list = [];

        //populate the return result
        // "custom name" => $row['database id']
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
            "TrackId" => $row['TrackId'], 
            "Name" => $row['Name'],
            "AlbumId" => $row['AlbumId'],
            //"MediaTypeId"
            "MediaType" => $row['MediaType'],
            //"GenreId"
            "Genre" => $row['Genre'],
            "Composer" => $row['Composer'],
            "Milliseconds" => $row['Milliseconds'],
            "Bytes" => $row['Bytes'],
            "UnitPrice" => $row['UnitPrice']
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
            SELECT TrackId, t.Name, AlbumId, mt.Name as MediaType, g.Name as Genre, Composer, Milliseconds, Bytes, UnitPrice FROM track t
            LEFT JOIN mediatype mt ON mt.MediaTypeId = t.MediaTypeId
            LEFT JOIN genre g ON g.GenreId = t.GenreId
            WHERE TrackId = ?
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
            "TrackId" => $row['TrackId'], 
            "Name" => $row['Name'],
            "AlbumId" => $row['AlbumId'],
            //"MediaTypeId"
            "MediaType" => $row['MediaType'],
            //"GenreId"
            "Genre" => $row['Genre'],
            "Composer" => $row['Composer'],
            "Milliseconds" => $row['Milliseconds'],
            "Bytes" => $row['Bytes'],
            "UnitPrice" => $row['UnitPrice']
        );

        return $return;
    }
    public function Create($name, $albumId, $MediaTypeId, $GenreId, $Composer, $Milliseconds, $Bytes, $UnitPrice){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO track (Name, AlbumId, MediaTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        SQL;
        //Prepare statement, bind and execute
        $object = $stmt = $con->prepare($query);
        if($object == false){
            return $con->error;
        }
        $bindStatus = $stmt->bind_param("siiisiid", $name, $albumId, $MediaTypeId, $GenreId, $Composer, $Milliseconds, $Bytes, $UnitPrice);
        
        if(!$bindStatus){
            return $con->error;
        }
        $status = $stmt->execute();

        if(!$status || $con->affected_rows < 1){
            return false;
        }else{
            return true;
        }
        

    }
    public function Update($TrackId ,$name, $albumId, $MediaTypeId, $GenreId, $Composer, $Milliseconds, $Bytes, $UnitPrice){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            Update track
            SET Name = ?, AlbumId = ?, MediaTypeId = ?, GenreId = ?, Composer = ?, Milliseconds = ?, Bytes = ?, UnitPrice = ?
            WHERE TrackId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("siiisiidi", $name, $albumId, $MediaTypeId, $GenreId, $Composer, $Milliseconds, $Bytes, $UnitPrice, $TrackId);
        $status = $stmt->execute();
        
        if(!$status || $con->affected_rows < 1){
            return false;
        }
        return true;
    
    }
    public function Delete($trackId){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //prepare statement
        $query = <<<'SQL'
        DELETE FROM track
        WHERE TrackId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $trackId);
        $status = $stmt->execute();
        if(!$status || $con->affected_rows < 1 ){
            return false;
        }else {
            return true;
        }
    }
    function IntegrityCheck($trackId) {
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        // SQL
        $query = <<<'SQL'
            SELECT InvoiceLineId 
            FROM InvoiceLine
            WHERE TrackId = ?;
        SQL;
        //prepare, bind, execute
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $trackId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //check amount
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
                "InvoiceLineId" => $row['InvoiceLineId']
                );
        }
        if(empty($list)){
            return true;
        }
        return false;
    }
    
}

?>