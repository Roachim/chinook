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
            "ArtistId" => $row['ArtistId'], 
            "Name" => $row['Name']
            );
        }

        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

        return $list;
    }
    public function Create(){
            
    }
    public function Update(){

    }
    public function Delete(){

    }
}


?>