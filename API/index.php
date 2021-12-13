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
define('ENTITY_TRACKS', 'tracks');
define('ENTITY_CUSTOMER', 'customers');
define('ENTITY_INVOICES', 'invoices');
define('ENTITY_INVOICELINES', 'invoicelines');
define('ENTITY_ADMINS', 'admins');

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

//json encode for correct return type = json_encode()

if ($pieces == 1) {
    echo 'APIDescription placeholder. Please use the readme.md included.'();
} else {
    if ($pieces > MAX_PIECES) {
        echo 'format error';
    } else {

        $entity = $urlPieces[POS_ENTITY];

        switch ($entity) {
            case ENTITY_ALBUMS: //----------------------------------------------------ALBUMS--------------------------------------------------------------------------------
                require_once('album.php');
                $album = new Album();

                $verb = $_SERVER['REQUEST_METHOD'];

                switch ($verb) {
                    case 'GET':                             //get all album
                        
                        echo json_encode($album->GetAll());
                        
                        break;
                    case 'POST':                            //create new album
                        if (!isset($_POST['Title']) || !isset($_POST['ArtistId'])) {
                            echo 'format error';
                        } else {
                            echo json_encode($album->Create($_POST['Title'], $_POST['ArtistId']));
                        }                        
                        break;
                    case 'PUT':                             //Update album
                        if (!isset($_PUT['AlbumId']) || !isset($_PUT['Title']) || !isset($_PUT['ArtistId'])) {
                            echo 'format error';
                        } else {
                            echo json_encode($album->Update($_PUT['AlbumId'], $_PUT['Title'], $_PUT['ArtistId']));
                        }                        
                        break;
                    case 'DELETE':                          //delete album
                        if ($pieces < MAX_PIECES) {
                            echo 'format error';
                        }
                        else {
                            echo json_encode($album->Delete(POS_ID));
                        }
                        break;                     
                }
                $album = null;
                break;  
            case ENTITY_ARTIST: //----------------------------------------------------ARTISTS--------------------------------------------------------------------------------
                require_once('artist.php');
                $artist = new Artist();

                $verb = $_SERVER['REQUEST_METHOD'];

                switch ($verb) {
                    case 'GET':
                        echo json_encode($artist->GetAll());                     //get all artists
                        break;
                    case 'POST':                                    // Add new film
                        if (!isset($_POST['title'])) {
                            echo 'format error';
                        } else {
                            echo $movie->add($_POST);
                        }
                        break;
                    case 'PUT':                                     // Update film
                        // Since PHP does not handle PUT parameters explicitly,
                        // they must be read from the request body's raw data
                        $movieData = (array) json_decode(file_get_contents('php://input'), TRUE);
                
                        if ($pieces < MAX_PIECES || !isset($movieData['title'])) {
                            echo 'format error';
                        } else {
                            echo $movie->update($urlPieces[POS_ID], $movieData);
                        }
                        break;
                    case 'DELETE':                                  // Delete film
                        if ($pieces < MAX_PIECES) {
                            echo 'format error';
                        } else {
                            echo $movie->delete($urlPieces[POS_ID]);
                        }
                        break;
                }
                $movie = null;
                break; 
            case ENTITY_CUSTOMER: //----------------------------------------------------CUSTOMERs--------------------------------------------------------------------------------
                require_once('customer.php');
                $artist = new Customer();

                $verb = $_SERVER['REQUEST_METHOD'];
                break;
            case ENTITY_INVOICES: //----------------------------------------------------INVOICES--------------------------------------------------------------------------------
                require_once('invoice.php');
                $artist = new Invoice();

                $verb = $_SERVER['REQUEST_METHOD'];
                break;
            case ENTITY_INVOICELINES: //----------------------------------------------------INVOICELINES--------------------------------------------------------------------------------
                require_once('invoiceline.php');
                $artist = new InvoiceLine();

                $verb = $_SERVER['REQUEST_METHOD'];
                break;
             case ENTITY_ADMINS: //----------------------------------------------------ADMINS--------------------------------------------------------------------------------
                require_once('admin.php');
                $artist = new Admin();

                $verb = $_SERVER['REQUEST_METHOD'];
                break;
            default:
                echo 'Format error';
        }
    }
}


?>