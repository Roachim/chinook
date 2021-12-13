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
        SELECT * FROM album
        SQL;
        $result = mysqli_query($con, $query);

        //populate the return result
        // custom name => database id
        $list=[];
        while ($row = mysqli_fetch_array($result)) {
            $list = array(
            "AlbumId" => htmlspecialchars($row['AlbumId']),
            "ArtistId" => htmlspecialchars($row['ArtistId']), 
            "Title" => htmlspecialchars($row['Title'])
            );
        }
        

        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

        return $list;
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
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'Album created';

    }
    public function Update($albumId ,$title, $artistId){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO album (Title, ArtistId)
            VALUES (?, ?)
            WHERE AlbumId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("sii", $title, $artistId, $albumId);
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'Album updated';
    
    }
    public function Delete($albumId){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //prepare statement
        $query = <<<'SQL'
        DELETE FROM album
        WHERE AlbumId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $albumId);
        $stmt->execute();
        //cut and return
        $db->cutConnection($con);
        return 'Album deleted';
    }
    

}


?>