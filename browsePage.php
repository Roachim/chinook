<?php

// if(isset($_POST['loginEmail']) && isset($_POST['loginPassword'])) {
//     // the form was submitted
//     $loginEmail = $_POST['loginEmail'];
//     $LoginPassword = $_POST['loginPassword'];

//     // ...
//     // perform your logic

//     // redirect if login was successful
//     header('Location: /somewhere');
// }
// else{
//     header('Location: localhost/chinook/frontend/loginPage.php');
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <section>
        <table id="trackList">
            <div>
                <tr></tr>
                <td></td>
                <td></td>
                <button></button>
            </div>
        </table>
        <table id="artistList">

        </table>
        <table id="albumList">

        </table>
    </section>
    <footer>

    </footer>
</body>
</html>

<!--
    The page should show all tracks, all artist and all albums.
A button to change window for each would be helpful.
each item must have a button to be added to cart.
Include a path to cart, include a path userInfo.
-->