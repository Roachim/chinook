<?php
//file access
require_once "artist.php";
require_once "album.php";
require_once "track.php";
require_once "admin.php";
require_once "customer.php";
require_once "invoice.php";
require_once "invoiceline.php";

//pos_entity gets the name trailing after API/, such as: albums or customers. accepted parameters are defined below as ENTITY_ALBUMS and ENTITY_CUSTOMER
define('POS_ENTITY', 1);
define('POS_ID', 2);
define('MAX_PIECES', 3);

define('ENTITY_ARTIST', 'artists');
define('ENTITY_ALBUMS', 'albums');
define('ENTITY_TRACKS', 'tracks');
define('ENTITY_CUSTOMERS', 'customers');
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
//cool
$url = substr($url, strpos($url, basename(__DIR__)));

$urlPieces = explode('/', urldecode($url));

header('Content-Type: application/json');
header('Accept-version: v1');

$pieces = count($urlPieces);

//lets make sure they have access first using sessions.
session_start();
    
    if (!isset($_SESSION['customerId']) && !isset($_SESSION['AdminId'])) {
        die('Session variable userID not set.<br>User not authenticated.');
    }

//define what type of request is made. e.g. GET or POST
$verb = $_SERVER['REQUEST_METHOD'];


if ($pieces == 1) {
    echo json_encode('API description placeholder. Please use the readme.md included for info.');
} else {
    if ($pieces > MAX_PIECES) {
        echo 'Invalid request form';
    } else {
        //from array of urlPieces, get the second and third. ignoring value 0, as 0 = API.
        $entity = $urlPieces[POS_ENTITY];
        if(count($urlPieces) > 2)
        {
            $id = $urlPieces[POS_ID];
        }
        else{
            $id = null;
        }
        

        switch ($entity) {
            case ENTITY_ALBUMS: //----------------------------------------------------ALBUMS--------------------------------------------------------------------------------
                require_once('album.php');
                $album = new Album();

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
            case ENTITY_TRACKS://----------------------------------------------------TRACKS--------------------------------------------------------------------------------
                $track = new Track();
                switch($verb){
                    case 'GET':
                        echo json_encode($track->GetAll());
                    break;
                    case 'POST':
                        break;
                    case 'DELETE':
                        break;
                }
                $track = null;
                break;
            case ENTITY_ARTIST: //----------------------------------------------------ARTISTS--------------------------------------------------------------------------------
                require_once('artist.php');
                $artist = new Artist();

                //$type = $_POST['action'];
                switch ($verb) {
                    case 'GET':
                        echo json_encode($artist->GetAll());                     //get all artists
                        break;
                    case 'POST':                                                //create new artist
                        if (isset($_POST['artistId'])) {
                            echo json_encode($artist->Update($_SERVER['artistId'], $_SERVER['name']));
                            break;
                        }
                        if (!isset($_POST['title'])) {
                            echo json_encode('format error');
                        } else {
                            //echo json_encode($artist->Create()) ;
                        }
                        break;
                    case 'POST':                                                 //update artist
                
                        if ($pieces < MAX_PIECES || !isset($movieData['title'])) {
                            
                        } else {
                            
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
                $artist = null;
                break; 
            case ENTITY_CUSTOMERS: //----------------------------------------------------CUSTOMERS--------------------------------------------------------------------------------
                require_once('customer.php');
                $customer = new Customer();
                
                switch ($verb) {
                    case 'GET':
                        echo json_encode($customer->GetAll());                     //get all customers
                        break;
                    case 'POST':
                        if (count($urlPieces) > 2) {
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
                $customer = null;
                break;
            case ENTITY_INVOICES: //----------------------------------------------------INVOICES--------------------------------------------------------------------------------
                require_once('invoice.php');
                $artist = new Invoice();
                case 'POST':                                                //create new artist
                    if ($type = 'UPDATE') {
                        echo json_encode($artist->Update($artistId, $name));
                        break;
                    }
                break;
            case ENTITY_INVOICELINES: //----------------------------------------------------INVOICELINES--------------------------------------------------------------------------------
                require_once('invoiceline.php');
                $artist = new InvoiceLine();
                break;
             case ENTITY_ADMINS: //----------------------------------------------------ADMINS--------------------------------------------------------------------------------
                require_once('admin.php');
                $artist = new Admin();
                break;
            case 'session':
                session_destroy();
                //echo 'Session destroyed';
                break;
                     
            default:
                echo json_encode('Wrong case: accepted cases can be seen in README.md');
                break;
        }
    }
}


?>