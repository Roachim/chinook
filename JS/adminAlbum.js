const url = 'API';
$("#editAlbumBtn").on("click", function(e){
    e.preventDefault();
    console.log('start');
    //load in all albums
    $.ajax({
        url: url + "/albums",
        type: 'GET',
        //dataType : 'json',
    success: function(data) {
        console.log(data);
        //table to append with results
        const table = $('#editAlbumList');
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
            cell = $('<button>Edit</button>', { 'id': item.AlbumId});
                
            row.append(cell);
            cell = $('<button>Delete</button>', { 'id': item.AlbumId});
            deleteAlbumFunc(cell);
            row.append(cell);
            table.append(div);
        });
    }, //end of success
    error: function(jqxhr, status, exception) {
        console.log('Exception:', exception);
        console.log(status);
        console.log(jqxhr.status);
        console.log(exception.message);
        console.log(console.warn(jqxhr.responseText));
    }//end of error
    }); //end of ajax
    console.log('end');
    $("#editArackList").css("display", "none");
    $("#editArtistList").css("display", "none");
    $("#editAlbumList").css("display", "block");
}); //end of button function

const editAlbumfunction = (function(button) {
    button.on("click", function() {
        //"get" using id from row
            const trackId = this.id;
            const title = $("#txtCustId").val().trim();
            const artist = $("#txtCustId").val().trim();

        $.ajax({
            url: url +"/customers/" + customerId,
            type: "POST",
            data: {
                title: title,
                artist: artist
            },
            success: function(data) {
                //parse from JSON to objects
                
                data = JSON.parse(JSON.stringify(data));
                //hide the password information
                $("#txtOldPassword").val("");
                $("#txtNewPassword").val("");
                
                //hideModal("userProfile");
                if (data) {
                    alert("The user profile was successfully updated. Please log in again");
                    
                    // Call the PHP API to end the session and redirect to the login page
                    //aye aye sir. Kinda cruel function though.
                    $.ajax({
                        url: url + "/session",
                        type: "POST",
                        data: {
                        },
                        success: function(data) {
                            window.location.replace('loginPage.php');
                        }
                    })

                } else {
                    alert("Incorrect password");
                }
            }
        })
        
    });
});

const deleteAlbumFunc = (function(button){
    button.on("click", function() {
        //"get" using id from row
            const trackId = this.id;

        $.ajax({
            url: url+"/albums/"+trackId,
            type: 'DELETE',
        })
        .done(function(data) {
            $("#editAlbumList").css("display", "none");
        });
    });
});
