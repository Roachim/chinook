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
    echo APIDescription();
} else {
    if ($pieces > MAX_PIECES) {
        echo formatError();
    } else {

        $entity = $urlPieces[POS_ENTITY];

        switch ($entity) {
            case ENTITY_PERSONS:
                require_once('src/person.php');
                $artist = new Artist();

                $verb = $_SERVER['REQUEST_METHOD'];

                switch ($verb) {
                    case 'GET':                             //get all artist
                        if (!isset($_GET['name'])) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($person->search($_GET['name']), ENTITY_PERSONS);
                        }
                        break;
                    case 'POST':                            //create new artist
                        if (!isset($_POST['name'])) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($person->add($_POST['name']), ENTITY_PERSONS);
                        }                        
                        break;
                    case 'DELETE':                          //delete artist
                        if ($pieces < MAX_PIECES) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($person->delete($urlPieces[POS_ID]), ENTITY_PERSONS);
                        }
                        break;                     
                }
                $person = null;
                break;  
            case ENTITY_FILMS:
                require_once('src/movie.php');
                $movie = new Movie();

                $verb = $_SERVER['REQUEST_METHOD'];

                switch ($verb) {
                    case 'GET':
                        if ($pieces < MAX_PIECES) {                  // Search films
                            if (!isset($_GET['title'])) {
                                echo formatError();
                            } else {
                                echo addHATEOAS($movie->search($_GET['title']), ENTITY_FILMS);
                            }
                        } else {                                    // Get film by ID
                            echo addHATEOAS($movie->get($urlPieces[POS_ID]), ENTITY_FILMS);
                        }
                        break;
                    case 'POST':                                    // Add new film
                        if (!isset($_POST['title'])) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($movie->add($_POST), ENTITY_FILMS);
                        }
                        break;
                    case 'PUT':                                     // Update film
                        // Since PHP does not handle PUT parameters explicitly,
                        // they must be read from the request body's raw data
                        $movieData = (array) json_decode(file_get_contents('php://input'), TRUE);
                
                        if ($pieces < MAX_PIECES || !isset($movieData['title'])) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($movie->update($urlPieces[POS_ID], $movieData), ENTITY_FILMS);
                        }
                        break;
                    case 'DELETE':                                  // Delete film
                        if ($pieces < MAX_PIECES) {
                            echo formatError();
                        } else {
                            echo addHATEOAS($movie->delete($urlPieces[POS_ID]), ENTITY_FILMS);
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