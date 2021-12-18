


http://_<server_name>_/chinook/api/_<collection>_/_<id>_

## API useage
--All id's at the end of a url is an <int>


nothing here really
GET http://localhost/chinook/api

## Artist--
GET http://localhost/chinook/api/artists -- to get all artist
POST http://localhost/chinook/api/artists -- to create a new artist
bodyname : {variable Type}--
artistName : {string}
POST http://localhost/chinook/api/artists/{id} - to update an existing artist
bodyname : {variable Type}--
artistName : {string}
DELETE http://localhost/chinook/api/artists/{id} -- to delete an artist

## Albums--
GET http://localhost/chinook/api/albums -- to get all albums
POST http://localhost/chinook/api/albums -- to create new album
bodyname : {variable Type}--
title : {string}
artistId : {int}
POST http://localhost/chinook/api/albums/{id} -- to update an album
bodyname : {variable Type}--
title : {string}
artistId : {int}
DELETE http://localhost/chinook/api/albums/{id} -- to delete an album

## Tracks--
GET http://localhost/chinook/api/tracks -- to get all tracks
POST http://localhost/chinook/api/tracks -- to create new track
bodyname : {variable Type}--
trackName : {string}
trackAlbumId : {int}
trackMediaTypeId : {int}
trackGenreId : {int}
trackComposer : {string}
trackMilliseconds : {int}
trackBytes : {int}
trackUnitPrice : {double}

POST http://localhost/chinook/api/tracks/{id} -- to update an existing track
bodyname : {variable Type}--
bodyname : {variable Type}--
trackName : {string}
trackAlbumId : {int}
trackMediaTypeId : {int}
trackGenreId : {int}
trackComposer : {string}
trackMilliseconds : {int}
trackBytes : {int}
trackUnitPrice : {double}

DELETE http://localhost/chinook/api/tracks/{id} -- to delete an existing track

## Customers--
GET http://localhost/chinook/api/customers -- to get all customers
POST http://localhost/chinook/api/customers -- to create a new customer
bodyname : {variable Type}--

POST http://localhost/chinook/api/customers/{id} -- to update an existing customer
bodyname : {variable Type}--

## invoices--
POST http://localhost/chinook/api/invoices -- to create a new invoice
bodyname : {variable Type}--





## POST and PUT(also POST) details

Albums:
