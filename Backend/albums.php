<?php include_once "db.php";
//implement whole CRUD
class Albums{
    //properties
    private $almbumId;
    private $title;
    private $artistId;
    //constructor
    //methods
    //getAllMethod
    
    public function AlbumsList(){
        $db = new DataBase();
        $con = $db->connection();

        if ($con) {
            $query = "SELECT * FROM album";
            $result = mysqli_query($con, $query);

        } else {
            return 'Connection error';
        }
        //array to return. retres = return result ᕕ( ᐛ )ᕗ
        $retres = [];

        //populate the return result
        // custom name => database id
        while ($row = mysqli_fetch_array($result)) {
            $retres[] = array(
            "ArtistId" => $row['ArtistId'], 
            "Name" => $row['Name']
            );
        }

        //cut connection to database before ending function
        $db->cutConnection($con);

        echo json_encode($retres);
    }
}


?>