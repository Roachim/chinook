<?php include_once "db.php";

//Create, read, Update
class Customer{
    //properties
    public $customerId;
    public $firstname;
    public $lastname;
    public $password;
    public $company;
    public $address;
    public $city;
    public $state;
    public $country;
    public $postalCode;
    public $phone;
    public $fax;
    public $email;
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
            WHERE CustomerId = ?
        SQL;
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        //create query result
        //$result = mysqli_query($con, $query);
        $result = $stmt->get_result();
        //populate the list from result
        // custom name => database id
        $list = [];
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
                "CustomerId" => htmlspecialchars($row['CustomerId']), 
                "FirstName" => htmlspecialchars($row['FirstName']),
                "LastName" => htmlspecialchars($row['LastName']),
                "Password" => htmlspecialchars($row['Password']),
                "Company" => htmlspecialchars($row['Company']),
                "Address" => htmlspecialchars($row['Address']),
                "City" => htmlspecialchars($row['City']),
                "State" => htmlspecialchars($row['State']),
                "Country" => htmlspecialchars($row['Country']),
                "PostalCode" => htmlspecialchars($row['PostalCode']),
                "Phone" => htmlspecialchars($row['Phone']),
                "Fax" => htmlspecialchars($row['Fax']),
                "Email" => htmlspecialchars($row['Email'])
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
        //remember to has password
        $Password = password_hash($Password, PASSWORD_DEFAULT);
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
        if($Password != null){
        //remember to has password
        $Password = password_hash($Password, PASSWORD_DEFAULT);
        }
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

        // hash check password
        return (password_verify($password, $result['password']));
    }
    //check if customer has any purchases via invoices. return true if integrity holds
    function IntegrityCheck($customerId) {
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        // SQL
        $query = <<<'SQL'
            SELECT InvoiceId 
            FROM Invoice
            WHERE CustomerId = ?;
        SQL;
        //prepare, bind, execute
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //check amount
        while ($row = mysqli_fetch_array($result)) {
            $list[] = array(
                "InvoiceId" => $row['InvoiceId']
                );
        }
        if(count($row) == 0 || count($row) == null){
            return true;
        }
        return false;
    }
}


?>