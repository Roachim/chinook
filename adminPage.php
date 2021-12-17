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
    <div> <!-- Create table -->
        <button id="showAddTrack">New Track</button>
        <button id="showAddArtist">New Artist</button>
        <button id="showAddAlbum">New Album</button>

        <form method="POST" id="trackCreateFrm" class="trackFrm">
            <h3>Create new track</h3>
            <fieldset>
                <label for="trackName">Name</label>
                <input type="text" id="trackName" value="" required>

                <label for="trackAlbumId">AlbumId</label>
                <input type="text" id="trackAlbumId" value="" required>

                <label for="trackMediaTypeId">MediaTypeId</label>
                <input type="text" id="trackMediaTypeId" value="" required>

                <label for="trackGenreId">GenreId</label>
                <input type="text" id="trackGenreId" value="" required>

                <label for="trackComposer">Composer</label>
                <input type="text" id="trackComposer" value="" required>

                <label for="trackMilliseconds">Milliseconds</label>
                <input type="text" id="trackMilliseconds" value="" required>

                <label for="trackBytes">Bytes</label>
                <input type="text" id="trackBytes" value="" required>

                <label for="trackUnitPrice">UnitPrice</label>
                <input type="text" id="trackUnitPrice" value="" required>

                <button id="addTrack">Add Track</button>
            </fieldset>
        </form>
        <form method="POST" id="artistCreateFrm" class="artistFrm">
            <h3>Create new artist</h3>
            <fieldset>
                <input type="text" id="artistName" value="" required>
                <button id="addArtist">Add Artist</button>
            </fieldset>
        </form>
        <form method="POST" id="albumCreateFrm" class="albumFrm">
            <h3>Create new album</h3>
            <fieldset>
                <label for="albumTitle">Album Title</label>
                <input type="text" id="albumTitle" value="" required>
                <label for="albumArtist">Artist(input id for desired artist)</label>
                <input type="text" id="albumArtist" value="" required>
                <button id="addAlbum">Add Album</button>
            </fieldset>
        </form>
    </div>
    <div> <!-- Update table -->
        <form method="POST" id="trackFrm" class="trackFrm">
            <h3>Edit Track</h3>
            <fieldset>
                <input type="hidden" id="newTrackId" value="" required>

                <label for="newTrackName">Name</label>
                <input type="text" id="newTrackName" value="" required>

                <label for="newTrackAlbumId">AlbumId</label>
                <input type="text" id="newTrackAlbumId" value="" required>

                <label for="newTrackMediaTypeId">MediaTypeId</label>
                <input type="text" id="newTrackMediaTypeId" value="" required>

                <label for="newTrackGenreId">GenreId</label>
                <input type="text" id="newTrackGenreId" value="" required>

                <label for="newTrackComposer">Composer</label>
                <input type="text" id="newTrackComposer" value="" required>

                <label for="newTrackMilliseconds">Milliseconds</label>
                <input type="text" id="newTrackMilliseconds" value="" required>

                <label for="newTrackBytes">Bytes</label>
                <input type="text" id="newTrackBytes" value="" required>

                <label for="newTrackUnitPrice">UnitPrice</label>
                <input type="text" id="newTrackUnitPrice" value="" required>

                <button id="changeTrack">Submit Change</button>
            </fieldset>
        </form>
        <form method="POST" id="artistFrm" class="artistFrm">
            <h3>Edit Artist</h3>
            <fieldset>
                <input type="hidden" id="newArtistId" value="" required>
                <label for="artistName">First name</label>
                <input type="text" id="newArtistName" value="" required>
                <button id="changeArtist">Submit Change</button>
            </fieldset>
        </form>
        <form method="POST" id="albumFrm" class="albumFrm">
            <h3>Edit Album</h3>
            <fieldset>
                <input type="hidden" id="newAlbumId" value="" required>
                <label for="newAlbumTitle">Album Title</label>
                <input type="text" id="newAlbumTitle" value="" required>
                <label for="newAlbumArtist">Current artist(input the id for the artist)</label>
                <input type="text" id="newAlbumArtist" value="" required>
                <button id="changeAlbum">Submit Change</button>
            </fieldset>
        </form>
    </div>
    <div>
        <button id="trackBtn">Track List</button>
        <button id="artistBtn">Artist List</button>
        <button id="albumBtn">Album List</button>

        <table id="trackList" class="trackList">
        </table>
        
        <table id="artistList" class="artistList">
        </table>

        <table id="albumList" class="albumList">
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="JS/adminAlbum.js" defer></script>
    <script src="JS/adminArtist.js" defer></script>
    <script src="JS/adminTrack.js" defer></script>
</body>
</html>