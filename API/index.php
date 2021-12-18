<?php
session_start();
//file access
require_once "artist.php";
require_once "album.php";
require_once "track.php";
require_once "admin.php";
require_once "customer.php";
require_once "invoice.php";

//pos_entity gets the name trailing after API/, such as: albums or customers. accepted parameters are defined below as ENTITY_ALBUMS and ENTITY_CUSTOMER
//define constants
define('POS_ENTITY', 1);
define('POS_ID', 2);
define('MAX_PIECES', 3);
//define more constants
define('ENTITY_ARTIST', 'artists');
define('ENTITY_ALBUMS', 'albums');
define('ENTITY_TRACKS', 'tracks');
define('ENTITY_CUSTOMERS', 'customers');
define('ENTITY_INVOICES', 'invoices');
define('ENTITY_INVOICELINES', 'invoicelines');
define('ENTITY_ADMINS', 'admins');



$url = strtok($_SERVER['REQUEST_URI'], "?");    // GET parameters are removed

// If there is a trailing slash, it is removed, so that it is not taken into account by the explode function
//smart
if (substr($url, strlen($url) - 1) == '/') {
    $url = substr($url, 0, strlen($url) - 1);
}
// Everything up to the folder where this file exists is removed.
// This allows the API to be deployed to any directory in the server
//cool
$url = substr($url, strpos($url, basename(__DIR__)));

// get a better read of the url by dividing and deleting the "/"
$urlPieces = explode('/', urldecode($url));

header('Content-Type: application/json');
header('Accept-version: v1');

$pieces = count($urlPieces);




//define what type of request is made. e.g. GET or POST
$verb = $_SERVER['REQUEST_METHOD'];
if($pieces > MAX_PIECES){
    die("Invalid URL.  Please check the readme.md");
}
//check csrf token if making a post request and validate
// if($verb == 'POST'){
//     if(empty($_SESSION['token'])){
//         echo header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed. No session.');
//         exit;
//     } else if(empty($_POST['token'])){
//         echo header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed. No token.');
//         exit;
//     } 
//     else if($_SESSION['token'] !=$_POST['token'] ){
//         $token = $_SESSION['token'];
//         echo header($_SERVER['SERVER_PROTOCOL'] . '405 Method Not Allowed. Tokens do not match.');
//         exit;
//     }
// }


if($verb === 'POST'){
    //apply the tokens value to a variable while filtering. because why not
    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

    //if session has not token, or no token was sent, well thats a big no no.
    if (!$token || $token !== $_SESSION['token']) {
        // return 405 http status code
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    } else {
        // process the form
    }
}





if ($pieces == 1) {
    echo json_encode('API description placeholder. Please use the readme.md included for info.');
} else {
    if ($pieces > MAX_PIECES) {
        echo header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    } else {
        //from array of urlPieces, get the second and third. ignoring value 0, as 0 = API.
        $entity = $urlPieces[POS_ENTITY];
        //lets make sure they have access first using sessions.
        
        if($entity == "customers" && $pieces == 2){
            //continue. can make a new customer without auth
        } else if (!isset($_SESSION['customerId']) && !isset($_SESSION['adminId'])) {
            die('Access denied. You are not authenticated to use this service.');
        }
        

        switch ($entity) {
            case ENTITY_ALBUMS: //----------------------------------------------------ALBUMS--------------------------------------------------------------------------------
                require_once('album.php');
                $album = new Album();

                switch ($verb) {
                    case 'GET':
                        if($pieces == MAX_PIECES)
                        {
                            echo json_encode($album->Get($urlPieces[POS_ID]));                             //get album
                        }else{
                            echo json_encode($album->GetAll());                             //get all albums
                        }
                        
                        break;
                    case 'POST':                            //create new album
                        if ($pieces == MAX_PIECES) {
                            echo json_encode($album->Update($_POST['albumId'], $_POST['title'], $_POST['artistId']));
                        } else {
                            echo json_encode($album->Create($_POST['title'], $_POST['artistId']));
                        }                        
                        break;
                    case 'DELETE':                          //delete album
                        if ($pieces < MAX_PIECES) {
                            echo json_encode('format error');
                        }
                        else {
                            echo json_encode($album->Delete($urlPieces[POS_ID]));
                        }
                        break;                     
                }
                $album = null;
                break;
            case ENTITY_TRACKS://----------------------------------------------------TRACKS--------------------------------------------------------------------------------
                require_once('track.php');
                $track = new Track();
                switch($verb){
                    case 'GET':
                        if($pieces == MAX_PIECES){
                            echo json_encode($track->Get($urlPieces[POS_ID]));//get artist
                        }else{
                            echo json_encode($track->GetAll());//get all artists
                        }
                                             
                        break;
                    case 'POST':

                        if ($pieces == MAX_PIECES) {                                                //create new artist
                            echo json_encode($track->Update($urlPieces[POS_ID], $_POST['trackName'], $_POST['trackAlbumId'], $_POST['trackMediaTypeId'], $_POST['trackGenreId'], 
                            $_POST['trackComposer'], $_POST['trackMilliseconds'], $_POST['trackBytes'], $_POST['trackUnitPrice']));
                        } else {                                                //update artist
                            echo json_encode($track->Create($_POST['trackName'], $_POST['trackAlbumId'], $_POST['trackMediaTypeId'], $_POST['trackGenreId'], 
                            $_POST['trackComposer'], $_POST['trackMilliseconds'], $_POST['trackBytes'], $_POST['trackUnitPrice']));
                        }                        
                        break;
                    case 'DELETE':                                  //delete artist
                        if ($pieces < MAX_PIECES) {
                            
                            echo json_encode('format error');
                        }
                        else {
                            if($track->IntegrityCheck($urlPieces[POS_ID])){
                                echo json_encode($track->Delete($urlPieces[POS_ID]));
                            }else{
                                echo json_encode('That track has an invoice. Cannot delete.');
                            }
                        }
                        break; 
                }
                $track = null;
                break;
            case ENTITY_ARTIST: //----------------------------------------------------ARTISTS--------------------------------------------------------------------------------
                require_once('artist.php');
                $artist = new Artist();
                switch ($verb) {
                    case 'GET':
                        if($pieces == MAX_PIECES){
                            echo json_encode($artist->Get($urlPieces[POS_ID]));//get artist
                        }else{
                            echo json_encode($artist->GetAll());//get all artists
                        }
                                             
                        break;
                    case 'POST':                                                //create new artist

                        if ($pieces == MAX_PIECES) {
                            echo json_encode($artist->Update($_POST['artistId'], $_POST['artistName']));
                        } else {
                            echo json_encode($artist->Create($_POST['artistName']));
                        }                        
                        break;
                    case 'DELETE':                                  //delete artist
                        if ($pieces < MAX_PIECES) {
                            
                            echo json_encode('format error');
                        }
                        else {
                            if($artist->IntegrityCheck($urlPieces[POS_ID])){
                                echo json_encode($artist->Delete($urlPieces[POS_ID]));
                            }else{
                                echo json_encode('That artist has an album.');
                            }
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
                        if ($pieces == MAX_PIECES) {
                            echo json_encode($customer->Update($urlPieces[POS_ID] ,$_POST['firstName'], 
                            $_POST['lastName'], $_POST['company'], $_POST['address'], $_POST['city'], 
                            $_POST['state'], $_POST['country'], $_POST['postalCode'], $_POST['phone'], 
                            $_POST['fax'], $_POST['email'], $_POST['password'],$_POST['newPassword'])); //Update customer
                        } else{
                            echo json_encode($customer->Create($_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['company'], $_POST['address'], $_POST['city'], 
                            $_POST['state'], $_POST['country'], $_POST['postalCode'], $_POST['phone'], $_POST['fax'], $_POST['email'])); //create new customer
                        }
                        break;
                    case 'DELETE':                        
                        echo header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');                          //delete customer
                        //the assignment does not specify having to remove customers at any point.
                        //Don't know if either admins or customers are supposed to be able to do it.
                        //As there is no specification about this function, it has been left empty.
                        //customers are permament. Once a customer, always a customer :D
                        break;

                }
                $customer = null;
                break;
            case ENTITY_INVOICES: //----------------------------------------------------INVOICES--------------------------------------------------------------------------------
                require_once('invoice.php');
                $invoice = new Invoice();
                switch ($verb){
                    case 'POST':      
                        echo json_encode($invoice->Create($_POST['customerId'], $_POST['invoiceDate'], $_POST['billingAddress'], $_POST['billingCity'], 
                        $_POST['billingState'], $_POST['billingCountry'], $_POST['billingPostal'], $_POST['total'], $_POST['itemArray']));
                    break;
                }
                
                $invoice = null;
                break;
            case 'session':
                session_destroy();
                echo json_encode(true);
                break;
                     
            default:
                echo json_encode('Wrong case: accepted cases can be seen in README.md');
                break;
        }
    }
}


?>