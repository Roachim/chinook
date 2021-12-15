const url = 'API';
$("#editAlbumBtn").on("click", function(e){
    e.preventDefault();
    console.log('pressed button');
    //load in all albums
    $.ajax({
        url: url+"/albums",
        type: 'GET',
        dataType : 'json'
    })
    .done(function(data) {
        console.log('in function');
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
            cell = $('<button>Edit</button>', { 'id': item.TrackId});
                
            row.append(cell);
            cell = $('<button>Delete</button>', { 'id': item.TrackId});
            deleteAlbumFunc(cell);
            row.append(cell);
            table.append(div);
        });
    });
    $("#editArackList").css("display", "none");
    $("#editArtistList").css("display", "none");
    $("#editAlbumList").css("display", "block");
});

const editAlbumfunction = (function(button) {
    button.on("click", function() {
        //"get" using id from row
            const trackId = this.id;
            const table = $('#addMovieContent');

        $.ajax({
            url: url +"/customers/" + customerId,
            type: "POST",
            data: {
                firstName: firstName,
                lastName: lastName,
                email: email,
                company: company,
                address: address,
                city: city,
                state: state,
                country: country,
                postalCode: postalCode,
                phone: phone,
                fax: fax,

                password: password,
                newPassword: newPassword
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
            $("#albumList").css("display", "none");
        });
    });
});
