<?php
    session_start();

    $userValidation = false;    

    // If the user has clicked on 'Logout', the session is destroyed
    if (isset($_POST['logout'])) { 
        session_destroy();
    
    // If the user is already logged in, s/he is redirected to the search page
    } else if (isset($_SESSION['customerId'])) {    
        header('Location: browsePage.php');

    // If the user has filled the login fields, the authentication process is launched
    } else if (isset($_POST['loginEmail']) && isset($_POST['loginPass'])) {
        
        $userValidation = true;
        require_once('API/customer.php');

        $email = $_POST['loginEmail'];
        $password = $_POST['loginPass'];

        $customer = new Customer();
        $validCustomer = $customer->validate($email, $password);
        if ($validCustomer === true) {
            session_start();

            $_SESSION['customerId'] = $customer->customerId;
            $_SESSION['firstName'] = $customer->firstName;
            $_SESSION['lastName'] = $customer->lastName;
            $_SESSION['password'] = $password;
            $_SESSION['company'] = $customer->company;
            $_SESSION['address'] = $customer->address;
            $_SESSION['city'] = $customer->city;
            $_SESSION['state'] = $customer->state;
            $_SESSION['country'] = $customer->country;
            $_SESSION['postalCode'] = $customer->postalCode;
            $_SESSION['phone'] = $customer->phone;
            $_SESSION['fax'] = $customer->fax;
            $_SESSION['email'] = $email;

            header('Location: browsePage.php');
        } else if($validCustomer === false){
            echo 'customer is false';
            echo $email;
            echo $password;
        } 
        else {
            if(is_int($validCustomer)){
                echo $validCustomer;
            }
            else{
                echo $validCustomer;
            }
            
        }
        //$CustomerId ,$FirstName, $LastName, $Password, $Company, $Address, $City, $State, $Country, $PostalCode, $Phone, $Fax, $Email
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/style.css">
    <title>Document</title>
    
</head>
<body>
    <header>
    <h1>Chinook Track Store</h1>

    </header>
    
    <form action="loginPage.php" method="POST">
        <input type="text" name="loginEmail" id="" placeholder="Email">
        <input type="password" name="loginPass" placeholder="password">
        <input type="submit" id="LoginBtn" value="Login">
    </form>
    <br>
    <button id="Btn">click for info</button>
    <table id="name" class="name"></table>

    <footer>
        <tr>Don't have an account?</tr>
        <br>
        <a href="createUser.php">Sign Up Here</a>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="JS/loginPage.js" defer></script>
</body>

</html>