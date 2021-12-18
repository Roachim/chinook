const url = 'API';

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
            cell = $('<button>Add to cart</button>');
            cell.attr("id", "e"+item.TrackId.toString());
            addToCart(cell);
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
    //change customer data
    $("#profileEdit").on("click", function() {
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

        const token = $("#csrf_token").val().trim();
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
                newPassword: newPassword,

                token: token
            },
            success: function(data) {
                
                if (data) {
                    alert("The user profile was successfully updated. Please log in again");
                    
                    // end session
                    $.ajax({
                        url: url + "/session",
                        type: "POST",
                        data: {
                            token: token
                        },
                        success: function(data) {
                            //window.location.replace('loginPage.php');
                        },
                        error: function(jqxhr, status, exception) {
                            console.log('Exception:', exception);
                            console.log(status);
                            console.log(jqxhr.status);
                            console.log(exception.message);
                            console.log(console.warn(jqxhr.responseText));
                        }//end of error
                    })
                    window.location.replace('loginPage.php');

                } else if(!data) {
                    alert("Error");
                }else {
                    alert(data);
                }
            }, //end of success
            error: function(jqxhr, status, exception) {
                console.log('Exception:', exception);
                console.log(status);
                console.log(jqxhr.status);
                console.log(exception.message);
                console.log(console.warn(jqxhr.responseText));
            }//end of error
        });
    });
    //Buy tracks from cart - 
    $("#buyTracks").on("click", function() {
        const customerId = $("#txtCustId").val().trim();
        const address = $("#billingAddress").val().trim();
        const city = $("#billingCity").val().trim();
        const state = $("#billingState").val().trim();
        const country = $("#billingCountry").val().trim();
        const postalCode = $("#billingPostalCode").val().trim();
        const total = $("#billingTotal").val().trim();
        
        //const itemArray = $("#cartItems").val().trim();
        //const itemArray = JSON.stringify(dataString);
        const token = $("#csrf_token").val().trim();

        //console.log(dataString);
        console.log('**********************************');
        console.log(customerId);
        console.log(address);
        console.log(city);
        console.log(state);
        console.log(country);
        console.log(postalCode);
        console.log(total);
        console.log('*************************');
        console.log();
        console.log();
        console.log();
        //console.log(jQuery.type(itemArray));
       
        $.ajax({
            url: "cart.php",
            type: "GET",
            success: function(data) {
                //$.each(data, function(i, item){});
                 
                const itemArray = data;
                console.log(itemArray);
                console.log('**********************************');
                $.ajax({
                    url: url +"/invoices",
                    type: "POST",
                    data: {
                        customerId: customerId,
                        billingAddress: address,
                        billingCity: city,
                        billingState: state,
                        billingCountry: country,
                        billingPostal: postalCode,
                        total: total,
                        itemArray: itemArray,
        
                        token: token
                    },
                    success: function(data) {
                        console.log('in success');
                        if (data == true) {
                            alert('Purchase complete');
        
                        } else {
                            alert(data);
                        }
                    }, //end of success
                    error: function(jqxhr, status, exception) {
                        console.log('Exception:', exception);
                        console.log(status);
                        console.log(jqxhr.status);
                        console.log(exception.message);
                        console.log(console.warn(jqxhr.responseText));
                    }//end of error
                });

            },
            error: function(jqxhr, status, exception){
                console.log('Exception:', exception);
                console.log(status);
                console.log(jqxhr.status);
                console.log(exception.message);
                console.log(console.warn(jqxhr.responseText));
            },
        });

        
        
    });
    //this method is amazingly bad
    //first: activate on button click
    const addToCart = (function(button) {
        button.on("click", function() {
            //"get" using id from button pressed
            const trackId = this.id.substring(1, this.id.length); 
            //alert('This button is under construction. Please use the input field above instead to add items to your cart.');
            console.log(trackId);
            //now make a call to cart.php to add item id to session cart
            $.ajax({
                url: "cart.php",
                type: "POST",
                data:{
                    trackId: trackId
                }
            })
            .done(function(data) {
                //when done: make a call to tracks to get the info of the track from newly inserted id. We want the price here.
                $.ajax({
                    url: url +"/tracks/" + trackId,
                    type: "GET",
                    success: function(data) {
                        //assuming we succeed. now add the unit price from track to billing total on html page for the customer
                        //$("#billingTotal").val($("#billingTotal").val() + data.UnitPrice);
                        const price = data.UnitPrice;
                        console.log(data.UnitPrice);
                        //finally, add the price to cartTotal session as well by making a post request to cartTotal.php
                        $.ajax({
                            url: "cartTotal.php",
                            type: "POST",
                            data:{
                                price: price
                            },
                            success: function(data) {
                                alert('item added to cart.');
                                location.reload();
                
                            },
                            error: function(jqxhr, status, exception){
                                console.log('Exception:', exception);
                                console.log(status);
                                console.log(jqxhr.status);
                                console.log(exception.message);
                                console.log(console.warn(jqxhr.responseText));
                            },
                        });
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
    });
    
    //Show/Hide buttons----------------------------------------------------------------------------------------------------------------------------------------------------
    $("#trackBtn").on("click", function(event){
        $("#trackList").css("display", "block");
        $("#artistList").css("display", "none");
        $("#albumList").css("display", "none");
        $("#editCustomerProfile").css("display", "none");
    });
    $("#artistBtn").on("click", function(event){
        $("#trackList").css("display", "none");
        $("#artistList").css("display", "block");
        $("#albumList").css("display", "none");
        $("#editCustomerProfile").css("display", "none");
    });
    $("#albumBtn").on("click", function(event){
        $("#trackList").css("display", "none");
        $("#artistList").css("display", "none");
        $("#albumList").css("display", "block");
        $("#editCustomerProfile").css("display", "none");
    });
    $("#hideProfile").on("click", function(event){
        $("#editCustomerProfile").css("display", "none");
    });
    $("#editProfile").on("click", function(event){
        $("#editCustomerProfile").css("display", "block");
        $("#trackList").css("display", "none");
        $("#artistList").css("display", "none");
        $("#albumList").css("display", "none");
    });
    $("#showCart").on("click", function(event){
        $("#editCustomerProfile").css("display", "none");
        $("#trackList").css("display", "none");
        $("#artistList").css("display", "none");
        $("#albumList").css("display", "none");
        $("#purchaseCart").css("display", "block");
        console.log('show cart');
    });