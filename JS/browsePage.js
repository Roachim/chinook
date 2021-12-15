//const base_url = "http://127.0.0.1/chinook/";
const url = 'API';
//url + /entity + /id

//load up data as sson as page is ready
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
            cell = $('<button>Add to cart</button>', { 'id': item.TrackId});
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

    $("button#btnProfileOk").on("click", function() {
        const customerId = $("#txtCustId").val().trim();
        const firstName = $("#txtFirstName").val().trim();
        const lastName = $("#txtLastName").val().trim();
        const email = $("#txtEmail").val().trim();
        const company = $("#txtCompany").val().trim();
        const address = $("#txtAddress").val().trim();
        const city = $("#txtCity").val().trim();
        const state = $("#txtState").val().trim();
        const country = $("#txtCountry").val().trim();
        const postalCode = $("#txtPostalCode").val().trim();
        const phone = $("#txtPhone").val().trim();
        const fax = $("#txtFax").val().trim();
        const password = $("#txtOldPassword").val().trim();
        const newPassword = $("#txtNewPassword").val().trim();

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
        });
    });

    //Show/Hide buttons----------------------------------------------------------------------------------------------------------------------------------------------------
    $("#trackBtn").on("click", function(event){
        $("#trackList").css("display", "block");
        $("#artistList").css("display", "none");
        $("#albumList").css("display", "none");
    });
    $("#artistBtn").on("click", function(event){
        $("#trackList").css("display", "none");
        $("#artistList").css("display", "block");
        $("#albumList").css("display", "none");
    });
    $("#albumBtn").on("click", function(event){
        $("#trackList").css("display", "none");
        $("#artistList").css("display", "none");
        $("#albumList").css("display", "block");
    });