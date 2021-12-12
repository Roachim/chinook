<?php
require_once "artist.php";
require_once "album.php";
require_once "track.php";
require_once "admin.php";
require_once "customer.php";
require_once "invoice.php";
require_once "invoiceline.php";

define('POS_ENTITY', 1);
define('POS_ID', 2);

define('MAX_PIECES', 3);

define('ENTITY_ARTIST', 'aritst');
define('ENTITY_ALBUMS', 'albums');

$url = strtok($_SERVER['REQUEST_URI'], "?");    // GET parameters are removed

// If there is a trailing slash, it is removed, so that it is not taken into account by the explode function
if (substr($url, strlen($url) - 1) == '/') {
    $url = substr($url, 0, strlen($url) - 1);
}
// Everything up to the folder where this file exists is removed.
// This allows the API to be deployed to any directory in the server
$url = substr($url, strpos($url, basename(__DIR__)));

$urlPieces = explode('/', urldecode($url));

header('Content-Type: application/json');
header('Accept-version: v1');

$pieces = count($urlPieces);

if ($pieces == 1) {
    echo 'APIDescription placeholder. Please use the readme.md included.'();
} else {
    if ($pieces > MAX_PIECES) {
        echo formatError();
    } else {

        $entity = $urlPieces[POS_ENTITY];

        switch ($entity) {
            case ENTITY_ALBUMS:
                require_once('album.php');
                $album = new Album();

                $verb = $_SERVER['REQUEST_METHOD'];

                switch ($verb) {
                    case 'GET':                             //get all album
                        
                        echo $album->GetAll();
                        
                        break;
                    case 'POST':                            //create new artist
                        if (!isset($_POST['name'])) {
                            echo formatError();
                        } else {
                            echo $person->add($_POST['name']);
                        }                        
                        break;
                    case 'DELETE':                          //delete artist
                        if ($pieces < MAX_PIECES) {
                            echo formatError();
                        } else {
                            echo $person->delete($urlPieces[POS_ID]);
                        }
                        break;                     
                }
                $album = null;
                break;  
            case ENTITY_ARTIST:
                require_once('artist.php');
                $artist = new Artist();

                $verb = $_SERVER['REQUEST_METHOD'];

                switch ($verb) {
                    case 'GET':
                        echo addHATEOAS($artist->GetAll(), ENTITY_ALBUMS);
                        break;
                    case 'POST':                                    // Add new film
                        if (!isset($_POST['title'])) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($movie->add($_POST), ENTITY_ARTIST);
                        }
                        break;
                    case 'PUT':                                     // Update film
                        // Since PHP does not handle PUT parameters explicitly,
                        // they must be read from the request body's raw data
                        $movieData = (array) json_decode(file_get_contents('php://input'), TRUE);
                
                        if ($pieces < MAX_PIECES || !isset($movieData['title'])) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($movie->update($urlPieces[POS_ID], $movieData), ENTITY_ARTIST);
                        }
                        break;
                    case 'DELETE':                                  // Delete film
                        if ($pieces < MAX_PIECES) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($movie->delete($urlPieces[POS_ID]), ENTITY_ARTIST);
                        }
                        break;
                }
                $movie = null;
                break; 
            default:
                echo formatError();
        }
    }
}


?>