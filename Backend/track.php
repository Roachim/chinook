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
     public function TrackList(){
        $db = new DataBase();
        $con = $db->connection();

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
        $retres = [];

        //populate the return result
        // "custom name" => $row['database id']
        while ($row = mysqli_fetch_array($result)) {
            $retres[] = array(
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

        echo json_encode($retres);
    }
    
}
$track = new Track();
$track->TrackList();

?>