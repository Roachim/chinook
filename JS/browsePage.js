//const base_url = "http://127.0.0.1/chinook/";
const url = 'API/calls.php';
$("#BtnTracks").on("click", function(e){
    $("#name").empty();
    
    

    //use to get info from html/php page via id of item
    //const keyword = $("#somethinhg").val();
    //const url = base_url + "Backend/track.php";
    
    

    $.ajax({
        url: url,
        type: 'GET',
        //expect json data
        //contentType : 'text/json',
        dataType : 'json'
    })
    .done(function(data) {
        console.log(data);
        //table to append with results
        const table = $('#name');
        const div = $("<div></div>");
        //alert(typeof(data));
        //console.log(data);

        $.each(data, function(i, item){
            
            let row = $('<tr></tr>', {'id': 'text'});

            let cell = $('<td></td>', { 'text': "Name" });
            
            cell = $('<td></td>', { 'text': item.Name });
            row.append(cell);
            row.append(cell);
            
            cell = $('<td></td>', { 'text': 'Album' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Album });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'MediaType' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.MediaType });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'Genre' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Genre });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'Composer' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Composer });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'Milliseconds' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Milliseconds });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'Bytes' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.Bytes });
            row.append(cell);

            cell = $('<td></td>', { 'text': 'UnitPrice' });
            row.append(cell);
            cell = $('<td></td>', { 'text': item.UnitPrice });
            row.append(cell);

            div.append(row);

        });
        table.append(div);
        
    });
});

$("#BtnArtists").on("click", function(e){
        e.preventDefault();
        //location.reload();
        
         alert("in old");
        //use to get info from html/php page via id of item
        var keyword = $("#somethinhg").val();
        var url = base_url + "Backend/artists.php";

        $.ajax({
            url: url,
            type: 'GET',
            dataType : 'json'
        })
        .done(function(data) {
            //table to append with results
            const table = $('#name');
            const div = $("<div></div>");
            //alert(typeof(data));
            //console.log(data);

            $.each(data, function(i, item){
                
                let row = $('<tr></tr>', {'id': 'text'});

                let cell = $('<td></td>', { 'text': "ArtistId" });
                row.append(cell);
                cell = $('<td></td>', { 'text': item.ArtistId });
                row.append(cell);
                
                cell = $('<td></td>', { 'text': 'Name' });
                row.append(cell);
                cell = $('<td></td>', { 'text': item.Name });
                row.append(cell);
                div.append(row);

            });
            table.append(div);
            
        });
    });
    $("#BtnAlbums").on("click", function(e){
        e.preventDefault();
        //use to get info from html/php page via id of item
        var keyword = $("#somethinhg").val();
        var url ="API/calls.php";

        $.ajax({
            url: url,
            type: 'GET',
            dataType : 'json'
        })
        .done(function(data) {
            //table to append with results
            const table = $('#name');
            const div = $("<div></div>");
            //alert(typeof(data));
            //console.log(data);

            $.each(data, function(i, item){
                
                let row = $('<tr></tr>', {'id': 'text'});

                let cell = $('<td></td>', { 'text': "ArtistId" });
                row.append(cell);
                cell = $('<td></td>', { 'text': item.ArtistId });
                row.append(cell);
                
                cell = $('<td></td>', { 'text': 'Name' });
                row.append(cell);
                cell = $('<td></td>', { 'text': item.Name });
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
            url: url,
            type: "POST",
            data: {
                entity: "customers",
                action: "UPDATE",
                customerId: customerId,
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
                        url: url,
                        type: "POST",
                        data: {
                            entity: "session",
                            action: "destroy"
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