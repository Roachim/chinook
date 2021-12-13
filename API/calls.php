<?php
require_once "artist.php";
require_once "album.php";
require_once "track.php";
require_once "admin.php";
require_once "customer.php";
require_once "invoice.php";
require_once "invoiceline.php";
session_start();
    if (!isset($_SESSION['customerId'])) {
        die('Session variable userID not set.<br>User not authenticated.');
    }
define('POS_ENTITY', 1);
define('POS_ID', 2);
define('MAX_PIECES', 3);

define('ENTITY_ARTIST', 'artists');
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
    echo json_encode('APIDescription placeholder. Please use the readme.md included for info.');
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
                            echo json_encode('format error');
                        } else {
                            echo json_encode($album->Create($_POST['Title'], $_POST['ArtistId']));
                        }                        
                        break;
                    case 'PUT':                             //Update album
                        if (!isset($_PUT['AlbumId']) || !isset($_PUT['Title']) || !isset($_PUT['ArtistId'])) {
                            echo json_encode('format error');
                        } else {
                            echo json_encode($album->Update($_PUT['AlbumId'], $_PUT['Title'], $_PUT['ArtistId']));
                        }                        
                        break;
                    case 'DELETE':                          //delete album
                        if ($pieces < MAX_PIECES) {
                            echo json_encode('format error');
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
                $type = $_POST['action'];
                switch ($verb) {
                    case 'GET':
                        echo json_encode($artist->GetAll());                     //get all artists
                        break;
                    case 'POST':                                                //create new artist
                        if ($type = 'UPDATE') {
                            echo json_encode($artist->Update($artistId, $name));
                        }
                        
                        if (!isset($_POST['title'])) {
                            echo json_encode('format error');
                        } else {
                            //echo json_encode($artist->Create()) ;
                        }
                        break;
                    case 'POST':                                                 //update artist
                        // Since PHP does not handle PUT parameters explicitly,
                        // they must be read from the request body's raw data
                        $movieData = (array) json_decode(file_get_contents('php://input'), TRUE);
                
                        if ($pieces < MAX_PIECES || !isset($movieData['title'])) {
                            echo json_encode('format error');
                        } else {
                            echo $movie->update($urlPieces[POS_ID], $movieData);
                        }
                        break;
                    case 'DELETE':                                  //delete artist
                        if ($pieces < MAX_PIECES) {
                            echo json_encode('format error');
                        } else {
                            echo $movie->delete($urlPieces[POS_ID]);
                        }
                        break;
                }
                $movie = null;
                break; 
            case ENTITY_CUSTOMER: //----------------------------------------------------CUSTOMERS--------------------------------------------------------------------------------
                require_once('customer.php');
                $customer = new Customer();

                $verb = $_SERVER['REQUEST_METHOD'];
                
                switch ($verb) {
                    case 'GET':
                        echo json_encode($customer->GetAll());                     //get all customers
                        break;
                    case 'POST':
                        $type = $_POST['action'];
                        if ($type = 'UPDATE') {
                            echo json_encode($customer->Update($_POST['customerId'] ,$_POST['firstName'], 
                            $_POST['lastName'], $_POST['company'], $_POST['address'], $_POST['city'], 
                            $_POST['state'], $_POST['country'], $_POST['postalCode'], $_POST['phone'], 
                            $_POST['fax'], $_POST['email'], $_POST['password'],$_POST['newPassword'])); //Update customer
                        } else{
                            echo json_encode($customer->Create($_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['company'], $_POST['address'], $_POST['city'], 
                            $_POST['state'], $_POST['country'], $_POST['postalCode'], $_POST['phone'], $_POST['fax'], $_POST['email'])); //create new customer
                        }
                        break;
                    case 'DELETE':                                                  //delete customer
                        if ($pieces < MAX_PIECES) {
                            echo json_encode('format error');
                        } else {
                            echo $movie->delete($urlPieces[POS_ID]);
                        }
                        break;

                }
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
            case 'session':
                switch ($action) {
                    case 'destroy':
                        session_destroy();
                        //echo 'Session destroyed';
                        break;
                    }
            default:
                echo json_encode('format error');
        }
    }
}


?>