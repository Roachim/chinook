const { parseJSON } = require("jquery");

//const url = 'API';
$("#trackBtn").on("click", function(e){
    e.preventDefault();
    $("#trackList").empty();
    //load in all track
    $.ajax({
        url: url + "/tracks",
        type: 'GET',
    success: function(data) {
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
                
                div.append(row);
            });
            cell = $('<button>Edit</button>');
            cell.attr("id", "e"+item.TrackId.toString());
            openTrackfunc(cell);
            row.append(cell);
            
            cell = $('<button>Delete</button>');
            cell.attr("id", "d"+item.TrackId.toString());
            deleteTrackFunc(cell);
            row.append(cell);
            
        });
        table.append(div);
    }, //end of success
    error: function(jqxhr, status, exception) {
        console.log('Exception:', exception);
        console.log(status);
        console.log(jqxhr.status);
        console.log(exception.message);
        console.log(console.warn(jqxhr.responseText));
    }//end of error
    }); //end of ajax
    $("#trackList").css("display", "block");
    $("#artistList").css("display", "none");
    $("#albumList").css("display", "none");
}); //end of button function


$("#addTrack").on("click", function(e) {
    e.preventDefault();
    const trackName = $("#trackName").val().trim();
    const trackAlbumId = $("#trackAlbumId").val().trim();
    const trackMediaTypeId = $("#trackMediaTypeId").val().trim();
    const trackGenreId = $("#trackGenreId").val().trim();
    const trackComposer = $("#trackComposer").val().trim();
    const trackMilliseconds = $("#trackMilliseconds").val().trim();
    const trackBytes = $("#trackBytes").val().trim();
    const trackUnitPrice = $("#trackUnitPrice").val().trim();

    const token = $("#csrf_token").val().trim();
    console.log("click");
    $.ajax({
        url: url +"/tracks",
        type: "POST",
        dataType : 'json',
        data: {
            trackName: trackName,
            trackAlbumId: trackAlbumId,
            trackMediaTypeId: trackMediaTypeId,
            trackGenreId: trackGenreId,
            trackComposer: trackComposer,
            trackMilliseconds: trackMilliseconds,
            trackBytes: trackBytes,
            trackUnitPrice: trackUnitPrice,

            token: token
        },
        success: function(data) {
            console.log('success');
            $("#trackCreateFrm").css("display", "none");
        },
        error: function(jqxhr, status, exception){
            console.log('Exception:', exception);
            console.log(status);
            console.log(jqxhr.status);
            console.log(exception.message);
            console.log(console.warn(jqxhr.responseText));
        }

    });
});
$("#changeTrack").on("click", function(e) {
    e.preventDefault();
    const trackId = $("#newTrackId").val().trim();
    const trackName = $("#newTrackName").val().trim();
    const trackAlbumId = $("#newTrackAlbumId").val().trim();
    const trackMediaTypeId = $("#newTrackMediaTypeId").val().trim();
    const trackGenreId = $("#newTrackGenreId").val().trim();
    const trackComposer = $("#newTrackComposer").val().trim();
    const trackMilliseconds = $("#newTrackMilliseconds").val().trim();
    const trackBytes = $("#newTrackBytes").val().trim();
    const trackUnitPrice = $("#newTrackUnitPrice").val().trim();

    const token = $("#csrf_token").val().trim();
    $.ajax({
        url: url +"/tracks/" + trackId,
        type: "POST",
        dataType : 'json',
        data: {
            trackName: trackName,
            trackAlbumId: trackAlbumId,
            trackMediaTypeId: trackMediaTypeId,
            trackGenreId: trackGenreId,
            trackComposer: trackComposer,
            trackMilliseconds: trackMilliseconds,
            trackBytes: trackBytes,
            trackUnitPrice: trackUnitPrice,

            token: token
        },
        success: function(data) {
                
            console.log('success');
            $("#trackFrm").css("display", "none");
        },
        error: function(jqxhr, status, exception){
            console.log('Exception:', exception);
            console.log(status);
            console.log(jqxhr.status);
            console.log(exception.message);
            console.log(console.warn(jqxhr.responseText));
        }

    });
});
const openTrackfunc = (function(button) {
    button.on("click", function() {
        //"get" using id from button pressed
        //remove first letter so it is now int'able
        const trackId = this.id.substring(1, this.id.length); 
        console.log(trackId);
        $.ajax({
            url: url +"/tracks/" + trackId,
            type: "GET",
            success: function(data) {
                
                $("#trackList").css("display", "none");

                $("#newTrackId").val(data.TrackId);
                $("#newTrackName").val(data.Name);
                $("#newTrackAlbumId").val(data.AlbumId);
                $("#newTrackMediaTypeId").val(data.MediaType);
                $("#newTrackGenreId").val(data.Genre);
                $("#newTrackComposer").val(data.Composer);
                $("#newTrackMilliseconds").val(data.Milliseconds);
                $("#newTrackBytes").val(data.Bytes);
                $("#newTrackUnitPrice").val(data.UnitPrice);

                $("#trackFrm").css("display", "block");
            },
            error: function(jqxhr, status, exception){
                console.log('Exception:', exception);
                console.log(status);
                console.log(jqxhr.status);
                console.log(exception.message);
                console.log(console.warn(jqxhr.responseText));
            }
        });
    });
});


const deleteTrackFunc = (function(button){
    button.on("click", function() {
        //"delete" using id from button pressed
        const trackId = parseInt(this.id.substring(1, this.id.length)); 
        $.ajax({
            url: url+"/tracks/"+trackId,
            type: 'DELETE',
            success: function(data) {
                
                $("#trackList").css("display", "none");
            },
            error: function(jqxhr, status, exception){
                console.log('Exception:', exception);
                console.log(status);
                console.log(jqxhr.status);
                console.log(exception.message);
                console.log(console.warn(jqxhr.responseText));
            }
            
        });
        
        
    });
});



//Show/Hide buttons----------------------------------------------------------------------------------------------------------------------------------------------------
$("#showAddTrack").on("click", function(event){
    $("#trackCreateFrm").css("display", "block");
    $("#artistCreateFrm").css("display", "none");
    $("#albumCreateFrm").css("display", "none");
});