<?php include_once "db.php";

//Create, read, Update
class Customer{
    //properties
    public int $customerId; //not null
    public string $firstName; //not null
    public string $lastName; //not null
    public string $password;
    public string $company;
    public string $address;
    public string $city;
    public string $state;
    public string $country;
    public string $postalCode;
    public string $phone;
    public string $fax;
    public string $email; //not null
    //constructor ??
    // function __construct()
    // { global $customerId;
    //     global $customerId;
    //     global $firstName;
    //     global $lastName;
    //     global $password;
    //     global $company;
    //     global $address;
    //     global $city;
    //     global $state;
    //     global $country;
    //     global $postalCode;
    //     global $phone;
    //     global $fax;
    //     global $email;
    //  $customerId = 0; //not null
    //  $firstName = ''; //not null
    //  $lastName = ''; //not null
    //  $password = '';
    //  $company = '';
    //  $address = '';
    //  $city = '';
    //  $state = '';
    //  $country = '';
    //  $postalCode = '';
    //  $phone = '';
    //  $fax = '';
    //  $email = '';
    // }
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
            $list = array(
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
    public function Update($CustomerId, $FirstName, $LastName, $Company, $Address, $City, $State, $Country, $PostalCode, $Phone, $Fax, $Email, $Password, $newPassword){
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        //SQL
        $query = <<<'SQL'
            UPDATE customer 
            SET FirstName = ?, 
            LastName = ?, 
            Company = ?, 
            Address = ?, 
            City = ?, 
            State = ?, 
            Country = ?, 
            PostalCode = ?, 
            Phone = ?, 
            Fax = ?, 
            Email = ?
        SQL;
        //split the SQL, insert new password before the 'where' clause to sandwich in updating the password when appropriate
        $passwordChange = (trim($newPassword) !== '');
        if ($passwordChange) {
            if ($this->validate($Email, $Password)) {                
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $query .= ', Password = ?';
            } else {
                return false;
            }
        }
        $query .= ' WHERE CustomerId = ?;';

        if($Password != null){
            //remember to hash password before inserting
            $Password = password_hash($Password, PASSWORD_DEFAULT);
        }
        //Prepare statement, bind and execute
        $stmt = $con->prepare($query);
        if($passwordChange){
            $stmt->bind_param("sssssssssssss", $FirstName, $LastName, $Company, $Address, $City, $State, $Country, $PostalCode, $Phone, $Fax, $Email, $newPassword, $CustomerId);
        }
        else{
            $stmt->bind_param("sssssssssssss", $FirstName, $LastName, $Company, $Address, $City, $State, $Country, $PostalCode, $Phone, $Fax, $Email, $CustomerId);
        }
        
        $stmt->execute();
        //cut connection
        
        $db->cutConnection($con);
        return true;
    
    }
    function validate($email, $password) {
        $db = new DataBase();
        $con = $db->connect();
        if (!$con) {
            die('Connection error');
        } 
        // SQL
        $query = <<<'SQL'
            SELECT CustomerId, FirstName, LastName, Password, Company, Address, City, State, Country, PostalCode, Phone, Fax, Email
            FROM customer
            WHERE Email = ?
        SQL;
        //prepare, bind, execute
        $stmt = $con->prepare($query);
        
        $stmt->bind_param("s", $email);
        
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $this->customerId = $row['CustomerId']; 
        $this->firstName = htmlspecialchars($row['FirstName']);
        $this->lastName = htmlspecialchars($row['LastName']);
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

        // hash check password
        if(!password_verify($password, $this->password)){
            return false;
        }
        return true;
    }
    //check if customer has any purchases via invoices. return true if integrity holds: customer has no purchases and is allowed to be deleted
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
    function PasswordCheck($password){

    }
}


?>