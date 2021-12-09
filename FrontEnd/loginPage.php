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
    
    <form action="browsePage.php" method="POST">
        <input type="text" name="loginName" id="" placeholder="username">
        <input type="password" name="loginPass" placeholder="password">
        <input type="submit">

    </form>
    <br>
    <button id="Btn">click for info</button>
    <table id="name" class="name"></table>

    <footer>
        <tr>Don't have an account?</tr>
        <br>
        <button id="AccountCreate"></button>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="JS/script.js" defer></script>
</body>

</html>