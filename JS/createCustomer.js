const url = 'API';

$("#profileBtn").on("click", function() {
    const firstName = $("#firstName").val().trim();
    const lastName = $("#lastName").val().trim();
    const password = $("#password").val().trim();
    const email = $("#email").val().trim();
    const company = $("#company").val().trim();
    const address = $("#address").val().trim();
    const city = $("#city").val().trim();
    const state = $("#state").val().trim();
    const country = $("#country").val().trim();
    const postalCode = $("#postalCode").val().trim();
    const phone = $("#phone").val().trim();
    const fax = $("#fax").val().trim();

    $.ajax({
        url: url +"/customers",
        type: "POST",
        data: {
            firstName: firstName,
            lastName: lastName,
            password: password,
            email: email,
            company: company,
            address: address,
            city: city,
            state: state,
            country: country,
            postalCode: postalCode,
            phone: phone,
            fax: fax
        },
        success: function(data) {
            if (data) {
                alert("Profile created");
                
            }else{
                alert('profile could be not created. A required field might not be set correctly.');
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