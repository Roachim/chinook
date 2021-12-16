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
        
        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

        return $return;
    }
    public function Create($name, $albumId, $MedieTypeId, $GenreId, $Composer, $Milliseconds, $Bytes, $UnitPrice){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO track (Name, AlbumId, MedieTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("siiisiid", $name, $albumId, $MedieTypeId, $GenreId, $Composer, $Milliseconds, $Bytes, $UnitPrice);
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'Track created';

    }
    public function Update($TrackId ,$name, $albumId, $MedieTypeId, $GenreId, $Composer, $Milliseconds, $Bytes, $UnitPrice){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO track (Name, AlbumId, MedieTypeId, GenreId, Composer, Milliseconds, Bytes, UnitPrice)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            WHERE TrackId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("siiisiidi", $name, $albumId, $MedieTypeId, $GenreId, $Composer, $Milliseconds, $Bytes, $UnitPrice, $TrackId);
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'Track updated';
    
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
        $stmt->execute();
        //cut and return
        $db->cutConnection($con);
        return 'Track deleted';
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
        if(count($row) == 0 || count($row) == null){
            return true;
        }
        return false;
    }
    
}

?>