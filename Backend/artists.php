<?php include_once "db.php";
//implement whole CRUD
// header('Content-Type: application/json');
// header('Accept-version: v1');
class Artist{
    //properties
    private $artistsId;
    private $name;
    //constructor
    function __constructor(){

    }
    //methods
    //getAllMethod
    public function GetAll(){
        $db = new DataBase();
        $con = $db->connect();
        if ($con) {
            $result = mysqli_query($con, $query);
        } else {
            return 'Connection error';
        }
        $query = <<<'SQL'
            SELECT * FROM artist
        SQL;
        //prepare and bind
        $stmt = $con->prepare($query);
        $stmt->execute();
        //populate the return result
        // custom name => database id
        $list = [];
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
            "ArtistId" => $row['ArtistId'], 
            "Name" => $row['Name']
            );
        }
        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

        return $list;
    }
    public function Create($track){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 

        $db->cutConnection($con);
        return;

    }
    public function Update(){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
    
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
        //prepare and bind
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $artistId);
        $stmt->execute();
        //cut and return
        $db->cutConnection($con);
        return 'Artist updated';
    }

}

$in = new Artist();


$in->ArtistList();

?>