<?php

session_start();

    if (!isset($_SESSION['adminId'])) {    
        header('Location: loginPage.php');
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
    <h1>Admin Page</h1>
    <div>
    <form action="loginPage.php" method="POST" id="logoutFrm" class="logoutFrm">
            <input type="submit" name="logout" value="Log Out">
    </form>
    </div>
    <div>
        <button id="editTrackBtn">Track List</button>
        <button id="editArtistBtn">Artist List</button>
        <button id="editAlbumBtn">Album List</button>

        <table id="editTrackList" class="trackList">
        </table>
        
        <table id="editArtistList" class="artistList">
        </table>

        <table id="editAlbumList" class="albumList">
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="JS/adminAlbum.js" defer></script>
    <script src="JS/adminArtist.js" defer></script>
    <script src="JS/adminTrack.js" defer></script>
</body>
</html>