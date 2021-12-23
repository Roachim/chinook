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
    <a href="index.php">back to login</a>
                    <fieldset id="customerProfile" class="newCustomer">

                        <h3>Create New Profile</h3>
                        <legend>customer profile</legend>
                        <label for="firstName">First name</label>
                        <input type="text" id="firstName" value="" required>
                        <label for="lastName">Last name</label>
                        <input type="text" id="lastName" value="" required>
                        <label for="email">Email</label>
                        <input type="text" id="email" value="" required>
                        <label for="password">Password</label>
                        <input type="password" id="password">
                        <label for="company">Company</label>
                        <input type="text" id="company" value="" >
                        <label for="address">Address</label>
                        <input type="text" id="address" value="" >
                        <label for="city">City</label>
                        <input type="text" id="city" value="" >
                        <label for="state">State</label>
                        <input type="text" id="state" value="" >
                        <label for="country">Country</label>
                        <input type="text" id="country" value="" >
                        <label for="postalCode">Postal code</label>
                        <input type="text" id="postalCode" value="" >
                        <label for="phone">Phone number</label>
                        <input type="text" id="phone" value="" >
                        <label for="fax">Fax</label>
                        <input type="text" id="fax" value="" >
                        
                        <button id="profileBtn">Create Profile</button>                    
                    </fieldset>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="JS/createCustomer.js" defer></script>
</body>
</html>