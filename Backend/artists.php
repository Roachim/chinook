<?php require_once "db.php";
// header('Content-Type: application/json');
// header('Accept-version: v1');
header('Content-Type: application/json');
header('Accept-version: v1'); 
class Artist{
    //properties
    private $artistsId;
    private $name;
    //constructor
    function __constructor(){

    }
    //methods
    //getAllMethod
    public function ArtistList(){
        $db = new DataBase();
        $con = $db->connection();

        if ($con) {
            $query = "SELECT * FROM artist";
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

$in = new Artist();


$in->ArtistList();

?>