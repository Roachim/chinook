


http://_<server_name>_/chinook/api/_<collection>_/_<id>_

## API how to:
--All id's at the end of a url is an <int>
--Required fields must not be null/empty
--All fields should be sent with the request, but non-required can be left null/empty
--All post request most include a token in the body called "token". The token is created when logged in as either customer or admin and can be found in a hidden field in the html. Use DevTools to find it. This token changes when logging out and logging in again.
--When using postman or otherwise, include a key "Cookie" in the headers with value set to "PHPSESSID={theSessionToken}". A valid session token can be found in under cookies, called "PHPSESSID" after logging in as either admin or customer. This session token will change when logging out and back in, as well as being useless when not logged in at all.

## defult. Nothing here really
GET http://localhost/chinook/api

## Artist--
GET http://localhost/chinook/api/artists -- to get all artist

POST http://localhost/chinook/api/artists -- to create a new artist
bodyname : {variable Type}--
artistName : {string} -- required

POST http://localhost/chinook/api/artists/{id} - to update an existing artist
bodyname : {variable Type}--
artistName : {string} -- required

DELETE http://localhost/chinook/api/artists/{id} -- to delete an artist

## Albums--
GET http://localhost/chinook/api/albums -- to get all albums

POST http://localhost/chinook/api/albums -- to create new album
bodyname : {variable Type}--
title : {string} -- required
artistId : {int} -- required

POST http://localhost/chinook/api/albums/{id} -- to update an album
bodyname : {variable Type}--
title : {string} -- required
artistId : {int} -- required

DELETE http://localhost/chinook/api/albums/{id} -- to delete an album

## Tracks--
GET http://localhost/chinook/api/tracks -- to get all tracks
POST http://localhost/chinook/api/tracks -- to create new track
bodyname : {variable Type}--
trackName : {string} -- required
trackAlbumId : {int}
trackMediaTypeId : {int} -- required
trackGenreId : {int}
trackComposer : {string}
trackMilliseconds : {int} -- required
trackBytes : {int}
trackUnitPrice : {double} -- required

POST http://localhost/chinook/api/tracks/{id} -- to update an existing track
bodyname : {variable Type}--
trackName : {string} -- required
trackAlbumId : {int}
trackMediaTypeId : {int} -- required
trackGenreId : {int}
trackComposer : {string}
trackMilliseconds : {int} -- required
trackBytes : {int}
trackUnitPrice : {double} -- required

DELETE http://localhost/chinook/api/tracks/{id} -- to delete an existing track

## Customers--
GET http://localhost/chinook/api/customers -- to get all customers

POST http://localhost/chinook/api/customers -- to create a new customer
bodyname : {variable Type}--
firstName : {string} -- required
lastName : {string} -- required
company : {string}
address : {string}
city : {string}
state : {string}
country : {string}
postalCode : {string}
phone : {string}
fax : {string}
email : {string} -- required
password : {string} -- required

POST http://localhost/chinook/api/customers/{id} -- to update an existing customer
bodyname : {variable Type}--
firstName : {string} -- required
lastName : {string} -- required
company : {string}
address : {string}
city : {string}
state : {string}
country : {string}
postalCode : {string}
phone : {string}
fax : {string}
email : {string} -- required
password : {string} -- required if new password is not empty, otherwise can be empty
newPassword : {string}

## Invoices--
POST http://localhost/chinook/api/invoices -- to create a new invoice
bodyname : {variable Type}--
customerId : {int} -- required
billingAddress : {string}
billingCity : {string}
billingState : {string}
billingCountry : {string}
billingPostal : {string}
total : {double} -- required
itemArray : {string} -- must be a string like the below examples. -- required


## string examples for itemArray
--Example 1--
["1"]
--Example 2--
["1","2","3"]
--Example 3--
["1","2","3","4","5","6"]


