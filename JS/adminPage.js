const url = 'API';

$(document).ready(function() {
    //Load in all tracks
    $.ajax({
        url: url+"/tracks",
        type: 'GET',
        dataType : 'json'
    })
    .done(function(data) {
        console.log(data);
        //table to append with results
        const table = $('#trackList');
        const div = $("<div></div>");
        $.each(data, function(i, item){
            const row = $('<tr></tr>', {'id': 'text'});
            let cell;
            const array = ["Name", "Albums", "MediaType", "Genre", "Composer", "Milliseconds", "Byte size", 'Price'];
            let x = 0;
            //set this to ignore the first value. It's the id
            let y=0;
            properties = $.each(item, function(p, property) {
                if(y==0)
                {
                    y=1;
                    return;
                } else{
                    if(property == '' || property == null){
                        property = 'Unknown';
                    }
                    cell = $('<td></td>', { 'text': array[x] +': ' });
                    row.append(cell);
                    cell = $('<td></td>', { 'text': property +'.'});
                    row.append(cell);
                    x = x+1;
                }
            });
            cell = $('<button>Edit</button>', { 'id': item.TrackId});
            row.append(cell);
            cell = $('<button>Delete</button>', { 'id': item.TrackId});
            row.append(cell);

            div.append(row);
        });
        table.append(div);
        
    });
    //load in all albums
    $.ajax({
        url: url+"/albums",
        type: 'GET',
        dataType : 'json'
    })
    .done(function(data) {
        console.log(data);
        //table to append with results
        const table = $('#albumList');
        const div = $("<div></div>");

        $.each(data, function(i, item){
            const row = $('<tr></tr>', {'id': 'text'});
            let cell;
            const array = ["Title", "Artist"];
            let x = 0;
            //set this to ignore the first value. It's the id
            let y=0;
            properties = $.each(item, function(p, property) {
                if(y==0)
                {
                    y=1;
                    return;
                } else{
                    if(property == '' || property == null){
                        property = 'Unknown';
                    }
                    cell = $('<td></td>', { 'text': array[x] +': ' });
                    row.append(cell);
                    cell = $('<td></td>', { 'text': property +'.'});
                    row.append(cell);
                    x = x+1;
                }
            });
            row.append(cell);

            div.append(row);

        });
        table.append(div);
        
    });
    //load in all artists
    $.ajax({
        url: url+"/artists",
        type: 'GET',
        dataType : 'json'
    })
    .done(function(data) {
        console.log(data);
        //table to append with results
        const table = $('#artistList');
        const div = $("<div></div>");

        $.each(data, function(i, item){
            const row = $('<tr></tr>', {'id': 'text'});
            let cell;
            const array = ['Name'];
            let x = 0;
            //set this to ignore the first value. It's the id
            let y=0;
            properties = $.each(item, function(p, property) {
                if(y==0)
                {
                    y=1;
                    return;
                } else{
                    if(property == '' || property == null){
                        property = 'Unknown';
                    }
                    cell = $('<td></td>', { 'text': array[x] +': ' });
                    row.append(cell);
                    cell = $('<td></td>', { 'text': property +'.'});
                    row.append(cell);
                    x = x+1;
                }
            });
            row.append(cell);

            div.append(row);
        });
        table.append(div);
        
    });
});
const editButtonFunc = (function(button){
    button.on("click", function() {
        //"get" using id from row
            const trackId = this.id;
            const table = $('#addMovieContent');

        $.ajax({
            url: url,
            type: 'GET',
        })
        .done(function(data) {

            //Title, release date, language, runtime, overview, link to the movie’s web page
            let row = $('<tr>General Info</tr>');
            let cell = $('<td></td>', { 'text': "Title" });
            row.append(cell);
            cell = $('<td></td>', { 'text': data.original_title });
            row.append(cell);

            cell = $('<td></td>', { 'text': "release date" });
            row.append(cell);
            cell = $('<td></td>', { 'text': data.release_date });
            row.append(cell);

            cell = $('<td></td>', { 'text': "Language" });
            row.append(cell);
            cell = $('<td></td>', { 'text': data.original_language });
            row.append(cell);

            cell = $('<td></td>', { 'text': "Runtime" });
            row.append(cell);
            cell = $('<td></td>', { 'text': data.runtime });
            row.append(cell);

            cell = $('<td></td>', { 'text': "Overview" });
            row.append(cell);
            cell = $('<td></td>', { 'text': data.overview });
            row.append(cell);

            cell = $('<td></td>', { 'text': "Link to movie web page" });
            row.append(cell);
            cell = $('<td></td>', { 'text': data.homepage });
            row.append(cell);

            table.append(row);
            //List of genres the movie belongs to
            row = $('<tr></tr>', { 'text': "List of Genres" });
            $.each(data.genres, function(i, item){
                cell = $('<td></td>', { 'text': item.name });
                row.append(cell);
            });
            table.append(row);
            //List of production companies involved in the making of the movie
            row = $('<tr></tr>', { 'text': "Production Companies" });
            $.each(data.production_companies, function(i, item){
                cell = $('<td></td>', { 'text': item.name });
                row.append(cell);
            });
            table.append(row);


            


        });
    });
});