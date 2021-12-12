<?php

if(isset($_POST['loginEmail']) && isset($_POST['loginPassword'])) {
    // the form was submitted
    $loginEmail = $_POST['loginEmail'];
    $LoginPassword = $_POST['loginPassword'];

    // ...
    // perform your logic

    // redirect if login was successful
    header('Location: /somewhere');
}
else{
    header('Location: localhost/chinook/frontend/loginPage.php');
}
    
    



?>