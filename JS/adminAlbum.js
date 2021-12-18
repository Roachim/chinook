const url = 'API';
$("#albumBtn").on("click", function(e){
    e.preventDefault();
    $("#albumList").empty();
    //load in all albums
    $.ajax({
        url: url + "/albums",
        type: 'GET',
        //dataType : 'json',
    success: function(data) {
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
                
                div.append(row);
            });
            cell = $('<button>Edit</button>');
            cell.attr("id", "e"+item.AlbumId.toString());
            openAlbumfunction(cell);
            row.append(cell);
            
            cell = $('<button>Delete</button>');
            cell.attr("id", "d"+item.AlbumId.toString());
            deleteAlbumFunc(cell);
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
    $("#trackList").css("display", "none");
    $("#artistList").css("display", "none");
    $("#albumList").css("display", "block");
}); //end of button function

const openAlbumfunction = (function(button) {
    button.on("click", function() {
        //"get" using id from button pressed
        const albumId = this.id.substring(1, this.id.length); 
        console.log(albumId);
        $.ajax({
            url: url +"/albums/" + albumId,
            type: "GET",
        })
        .done(function(data) {
            $("#editAlbumList").css("display", "none");
            $("#albumId").val(data.AlbumId);
            $("#albumTitle").val(data.Title);
            $("#albumArtist").val(data.Name);
            $("#albumFrm").css("display", "block");
        });
    });
});
$("#addAlbum").on("click", function(e) {
    e.preventDefault();
    const title = $("#albumTitle").val().trim();
    const artistId = $("#albumArtist").val().trim();

    const token = $("#csrf_token").val().trim();
    $.ajax({
        url: url +"/albums",
        type: "POST",
        dataType : 'json',
        data: {
            title: title,
            artistId: artistId,

            token: token
        },
        success: function(data) {
                
            console.log('success');
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
$("#changeAlbum").on("click", function(e) {
    e.preventDefault();
    const albumId = $("#newAlbumId").val().trim();
    const title = $("#newAlbumTitle").val().trim();
    const artistId = $("#newAlbumArtist").val().trim();

    const token = $("#csrf_token").val().trim();
    console.log("click");
    $.ajax({
        url: url +"/albums/" + albumId,
        type: "POST",
        dataType : 'json',
        data: {
            albumId: albumId,
            title: title,
            artistId: artistId,

            token: token
        },
        success: function(data) {
                
            console.log('success');

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

const deleteAlbumFunc = (function(button){
    button.on("click", function() {
        //"delete" using id from button pressed
        const albumId = parseInt(this.id.substring(1, this.id.length)); 
        $.ajax({
            url: url+"/albums/"+albumId,
            type: 'DELETE',
        })
        .done(function(data) {
            $("#albumList").css("display", "none");
        });
    });
});
//Show/Hide buttons----------------------------------------------------------------------------------------------------------------------------------------------------
$("#showAddAlbum").on("click", function(event){
    $("#trackCreateFrm").css("display", "none");
    $("#artistCreateFrm").css("display", "none");
    $("#albumCreateFrm").css("display", "block");
});