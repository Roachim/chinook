<?php include_once "db.php";

//Create, read, Update
class Customer{
    //properties
    private $customerId;
    private $firstname;
    private $lastname;
    private $password;
    private $company;
    private $address;
    private $city;
    private $state;
    private $country;
    private $postalCode;
    private $phone;
    private $fax;
    private $email;
    //constructor
    //methods
    public function GetAll(){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');   
        }
        //SQL
        $query = <<<'SQL'
            SELECT * FROM customer
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->execute();
        //create query result
        //$result = mysqli_query($con, $query);
        $result = $stmt->get_result();
        //populate the list from result
        // custom name => database id
        $list = [];
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
            "CustomerId" => $row['CustomerId'], 
            "FirstName" => $row['FirstName'],
            "LastName" => $row['LastName'],
            "Password" => $row['Password'],
            "Company" => $row['Company'],
            "Address" => $row['Address'],
            "City" => $row['City'],
            "State" => $row['State'],
            "Country" => $row['Country'],
            "PostalCode" => $row['PostalCode'],
            "Phone" => $row['Phone'],
            "Fax" => $row['Fax'],
            "Email" => $row['Email'],
            );
        }
        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

        return $list;
    }
    public function Get($customerId){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');   
        }
        //SQL
        $query = <<<'SQL'
            SELECT * FROM customer
            WHERE CustomerId
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->execute();
        //create query result
        //$result = mysqli_query($con, $query);
        $result = $stmt->get_result();
        //populate the list from result
        // custom name => database id
        $list = [];
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
                "CustomerId" => $row['CustomerId'], 
                "FirstName" => $row['FirstName'],
                "LastName" => $row['LastName'],
                "Password" => $row['Password'],
                "Company" => $row['Company'],
                "Address" => $row['Address'],
                "City" => $row['City'],
                "State" => $row['State'],
                "Country" => $row['Country'],
                "PostalCode" => $row['PostalCode'],
                "Phone" => $row['Phone'],
                "Fax" => $row['Fax'],
                "Email" => $row['Email'],
                );
        }
        //cut connection to database before ending function ᕕ( ᐛ )ᕗ
        $db->cutConnection($con);

        return $list;
    }
    public function Create($FirstName, $LastName, $Password, $Company, $Address, $City, $State, $Country, $PostalCode, $Phone, $Fax, $Email){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO customer (FirstName, LastName, Password, Company, Address, City, State, Country, PostalCode, Phone, Fax, Email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssssssssssss", $FirstName, $LastName, $Password, $Company, $Address, $City, $State, $Country, $PostalCode, $Phone, $Fax, $Email);
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'User account created';

    }
    public function Update($CustomerId ,$FirstName, $LastName, $Password, $Company, $Address, $City, $State, $Country, $PostalCode, $Phone, $Fax, $Email){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            INSERT INTO customer (FirstName, LastName, Password, Company, Address, City, State, Country, PostalCode, Phone, Fax, Email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            WHERE CustomerId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssssssssss", $FirstName, $LastName, $Password, $Company, $Address, $City, $State, $Country, $PostalCode, $Phone, $Fax, $Email, $CustomerId);
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return 'User account updated';
    
    }
    function validate($email, $password) {
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        // SQL
        $query = <<<'SQL'
            SELECT CustomerId, FirstName, LastName, Password 
            FROM user
            WHERE email = ?;
        SQL;
        //prepare, bind, execute
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //check amount
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
                "CustomerId" => $row['CustomerId']
                );
        }
        if(count($row) == 0 || count($row) == null){
            return false;
        }

        // $user = $stmt->fetch();

        // $this->userID = $user['CustomerId'];
        // $this->firstName = $user['FirstName'];
        // $this->lastName = $user['LastName'];
        // $this->email = $email;

        // Check the password
        return (password_verify($password, $result['password']));
    }
}


?>