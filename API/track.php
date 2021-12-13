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

        if ($con) {
            $query = <<<'SQL'
            SELECT TrackId, t.Name, AlbumId, mt.Name as MediaType, g.Name as Genre, Composer, Milliseconds, Bytes, UnitPrice FROM track t
            LEFT JOIN mediatype mt ON mt.MediaTypeId = t.MediaTypeId
            LEFT JOIN genre g ON g.GenreId = t.GenreId
            SQL;

            $result = mysqli_query($con, $query);

        } else {
            return 'Connection error';
        }
        //array to return. retres = return result ᕕ( ᐛ )ᕗ
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

        //cut connection to database before ending function
        $db->cutConnection($con);

        return $list;
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