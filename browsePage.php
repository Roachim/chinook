<?php
    session_start();

    if (!isset($_SESSION['customerId'])) {    
        header('Location: loginPage.php');
    }
    $customerId = $_SESSION['customerId'];
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];
    $password = $_SESSION['password'];
    $company = $_SESSION['company'];
    $address = $_SESSION['address'];
    $city = $_SESSION['city'];
    $state = $_SESSION['state'];
    $country = $_SESSION['country'];
    $postalCode = $_SESSION['postalCode'];
    $phone = $_SESSION['phone'];
    $fax = $_SESSION['fax'];
    $email = $_SESSION['email'];
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
     <h1>Browsing page</h1>
     <div>
         <button>User profile</button>
         <button>Cart</button>
     </div>
    </header>
    <div id="modalUserProfile" class="modal">
            <header>
                <h3 ie="headerProfile">Edit user profile</h3>
            </header>
            <main>
                <form id="editCustomerProfile" method="POST">
                    <fieldset>
                        <legend>customer profile</legend>
                        <input type="hidden" id="txtCustId" value="<?= $customerId?>" required>
                        <label for="txtFirstName">First name</label>
                        <input type="text" id="txtFirstName" value="<?= $firstName?>" required>
                        <label for="txtLastName">Last name</label>
                        <input type="text" id="txtLastName" value="<?= $lastName?>" required>
                        <label for="txtEmail">Email</label>
                        <input type="text" id="txtEmail" value="<?= $email?>" required>
                        <label for="txtCompany">Company</label>
                        <input type="text" id="txtCompany" value="<?= $company?>" >
                        <label for="txtAddress">Address</label>
                        <input type="text" id="txtAddress" value="<?= $address?>" >
                        <label for="txtCity">City</label>
                        <input type="text" id="txtCity" value="<?= $city?>" >
                        <label for="txtState">State</label>
                        <input type="text" id="txtState" value="<?= $state?>" >
                        <label for="txtCountry">Country</label>
                        <input type="text" id="txtCountry" value="<?= $country?>" >
                        <label for="txtPostalCode">Postal code</label>
                        <input type="text" id="txtPostalCode" value="<?= $postalCode?>" >
                        <label for="txtPhone">Phone number</label>
                        <input type="text" id="txtPhone" value="<?= $phone?>" >
                        <label for="txtFax">Fax</label>
                        <input type="text" id="txtFax" value="<?= $fax?>" >
                        <fieldset>
                            <legend>Password change</legend>
                            <label for="txtOldPassword">Old password</label>
                            <input type="password" id="txtOldPassword">
                            <label for="txtNewPassword">New password</label>
                            <input type="password" id="txtNewPassword">
                        </fieldset>                        
                    </fieldset>
                </form>
            </main>
            <div class="buttons">
                <button id="btnProfileOk">Change data</button>
                <button id="btnProfileCancel">Cancel</button>
            </div>
    </div>
    <div>
    <button id="trackBtn">Track List</button>
    <button id="artistBtn">Artist List</button>
    <button id="albumBtn">Album List</button>
        <table id="trackList" class="trackList">
            <div>
                <tr></tr>
                <td></td>
                <td></td>
                <button></button>
            </div>
        </table>
        
        <table id="artistList" class="artistList">
        </table>

        <table id="albumList" class="albumList">
        </table>
    </div>
        
    
    <footer>

    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="JS/browsePage.js" defer></script>
</body>
</html>

<!--
    The page should show all tracks, all artist and all albums.
A button to change window for each would be helpful.
each item must have a button to be added to cart.
Include a path to cart, include a path to userInfo.
-->