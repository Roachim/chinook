$("#btnProfileOk").on("click", function() {
    const customerId = $("#txtCustId").val().trim();
    const firstName = $("#txtFirstName").val().trim();
    const lastName = $("#txtLastName").val().trim();
    const password = $("#txtOldPassword").val().trim();
    const email = $("#txtEmail").val().trim();
    const company = $("#txtCompany").val().trim();
    const address = $("#txtAddress").val().trim();
    const city = $("#txtCity").val().trim();
    const state = $("#txtState").val().trim();
    const country = $("#txtCountry").val().trim();
    const postalCode = $("#txtPostalCode").val().trim();
    const phone = $("#txtPhone").val().trim();
    const fax = $("#txtFax").val().trim();

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
                alert('profile could be created. A required field might not be set correctly.');
            }
        }
    });
});