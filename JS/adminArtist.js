//const url = 'API';
$("#artistBtn").on("click", function(e){
    e.preventDefault();
    $("#artistList").empty();
    //load in all artist
    $.ajax({
        url: url + "/artists",
        type: 'GET',
    success: function(data) {
        console.log(data);
        //table to append with results
        const table = $('#artistList');
        const div = $("<div></div>");

        $.each(data, function(i, item){
            const row = $('<tr></tr>', {'id': 'text'});
            let cell;
            const array = ["Name"];
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
            cell.attr("id", "e"+item.ArtistId.toString());
            openArtistfunc(cell);
            row.append(cell);
            
            cell = $('<button>Delete</button>');
            cell.attr("id", "d"+item.ArtistId.toString());
            deleteArtistFunc(cell);
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
    $("#artistList").css("display", "block");
    $("#albumList").css("display", "none");
    //hide other forms
    $("#trackCreateFrm").css("display", "none");
    $("#artistCreateFrm").css("display", "none");
    $("#albumCreateFrm").css("display", "none");
    $("#albumFrm").css("display", "none");
    $("#trackFrm").css("display", "none");
    $("#artistFrm").css("display", "none");
}); //end of button function


$("#addArtist").on("click", function(e) {
    e.preventDefault();
    const artistName = $("#artistName").val().trim();

    const token = $("#csrf_token").val().trim();
    console.log("click");
    $.ajax({
        url: url +"/artists",
        type: "POST",
        dataType : 'json',
        data: {
            artistName: artistName,
            token: token
        },
        success: function(data) {
                
            console.log('success');
            $("#artistCreateFrm").css("display", "none");
        },
        error: function(jqxhr, status, exception){
            console.log('Exception:', exception);
            console.log(status);
            console.log(jqxhr.status);
            console.log(exception.message);
            console.log(console.warn(jqxhr.responseText));
        }

    });
    alert('Artist Added');
    location.reload();
});
$("#changeArtist").on("click", function(e) {
    e.preventDefault();
    const artistId = $("#newArtistId").val().trim();
    const artistName = $("#newArtistName").val().trim();

    const token = $("#csrf_token").val().trim();
    $.ajax({
        url: url +"/artists/" + artistId,
        type: "POST",
        dataType : 'json',
        data: {
            artistId: artistId,
            artistName: artistName,

            token:token
        },
        success: function(data) {
                
            alert('Artist edited');
            $("#artistCreateFrm").css("display", "none");
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
const openArtistfunc = (function(button) {
    button.on("click", function() {
        //"get" using id from button pressed
        //remove first letter so it is now int'able
        const artistId = this.id.substring(1, this.id.length); 
        console.log(artistId);
        $.ajax({
            url: url +"/artists/" + artistId,
            type: "GET",
            success: function(data) {
                
                $("#artistList").css("display", "none");
                $("#newArtistId").val(data.ArtistId);
                $("#newArtistName").val(data.Name);
                $("#albumFrm").css("display", "none");
                $("#trackFrm").css("display", "none");
                $("#artistFrm").css("display", "block");

    
            },
            error: function(jqxhr, status, exception){
                console.log('Exception:', exception);
                console.log(status);
                console.log(jqxhr.status);
                console.log(exception.message);
                console.log(console.warn(jqxhr.responseText));
                alert(exception);
            }
        });
    });
});


const deleteArtistFunc = (function(button){
    button.on("click", function() {
        //"delete" using id from button pressed
        const artistId = parseInt(this.id.substring(1, this.id.length)); 
        $.ajax({
            url: url+"/artists/"+artistId,
            type: 'DELETE',
            success: function(data) {
                alert('Artist deleted');
                $("#artistList").css("display", "none");
            },
            error: function(jqxhr, status, exception){
                console.log('Exception:', exception);
                console.log(status);
                console.log(jqxhr.status);
                console.log(exception.message);
                console.log(console.warn(jqxhr.responseText));
                alert('Artist has album(s) and cannot be deleted');
            }
            
        });
    });
});



//Show/Hide buttons----------------------------------------------------------------------------------------------------------------------------------------------------
$("#showAddArtist").on("click", function(event){
    //hide Forms for update table
    $("#albumFrm").css("display", "none");
    $("#trackFrm").css("display", "none");
    $("#artistFrm").css("display", "none");
    //hide Lists
    $("#artistList").css("display", "none");
    $("#albumList").css("display", "none");
    $("#trackList").css("display", "none");
    //only specific create form
    $("#trackCreateFrm").css("display", "none");
    $("#artistCreateFrm").css("display", "block");
    $("#albumCreateFrm").css("display", "none");
    
});