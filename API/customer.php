<?php include_once "db.php";

//Create, read, Update
class Customer{
    //properties
    public int $customerId;
    public string $firstname;
    public string $lastname;
    public string $password;
    public string $company;
    public string $address;
    public string $city;
    public string $state;
    public string $country;
    public string $postalCode;
    public string $phone;
    public string $fax;
    public string $email;
    //constructor ??
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
        // custom name => database id. Custom name is what i look for in ajax call
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
            FROM customer
            WHERE Email = ?;
        SQL;
        //prepare, bind, execute
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //check amount
        if(mysqli_fetch_array($result) == null){

        }
        else if(count(mysqli_fetch_array($result)) == 0 || count(mysqli_fetch_array($result)) == null){
            return false;
        }

        //put values into properties of customer
        while ($row = mysqli_fetch_array($result)) {
            
                $this->customerId = htmlspecialchars($row['CustomerId']); 
                $this->firstname = htmlspecialchars($row['FirstName']);
                $this->lastname = htmlspecialchars($row['LastName']);
                $this->password = $row['Password'];
                $this->company = htmlspecialchars($row['Company']);
                $this->address = htmlspecialchars($row['Address']);
                $this->city = htmlspecialchars($row['City']);
                $this->state = htmlspecialchars($row['State']);
                $this->country = htmlspecialchars($row['Country']);
                $this->postalCode = htmlspecialchars($row['PostalCode']);
                $this->phone = htmlspecialchars($row['Phone']);
                $this->fax = htmlspecialchars($row['Fax']);
                $this->email = htmlspecialchars($row['Email']);
                break;
            
        }

        // hash check password
        return (password_verify($password, $this->password));
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