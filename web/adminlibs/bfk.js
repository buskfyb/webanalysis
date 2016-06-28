
function isItInt(value) {
    var x;
    if (isNaN(value)) {
      return false;
    }
    x = parseFloat(value);
    return (x | 0) === x;
}

function validateForm() {
    var formOK = true;

    if ($('#libraryname').val() == "") {
        $('#libraryname_error').html("Må legge inn navn.");
        formOK = false;        
    }  else {
        $('#libraryname_error').html("");
    }

    if (!isItInt($('#siteid').val())) {
        $('#siteid_error').html("Må være tall.");
        formOK = false;
    } else {
        $('#siteid_error').html("");
    }

    if (!isItInt($('#population').val())) {
        $('#population_error').html("Må være tall.");
        formOK = false;
    } else {
        $('#population_error').html("");
    }

    // submit if all is OK    
    if (formOK) {$('#libraryForm').submit();}
}

function validatePasswordForm() {
    formOK = true;
 
    if ($('#password').val().length < 6) {
        $('#password_error').html("Passordet må være minst 6 tegn langt.");
        formOK = false;
    } else {
        $('#password_error').html("");
    }   

    // submit if all is OK    
    if (formOK) {$('#userForm').submit();}
   
}

function validateUserForm(withPass) {
    var formOK = true;

    if ($('#username').val() == "") {
        $('#username_error').html("Må legge inn brukernavn.");
        formOK = false;        
    }  else {
        $('#username_error').html("");
    }

    if ($('#name').val() == "") {
        $('#name_error').html("Må legge inn navn.");
        formOK = false;
    } else {
        $('#name_error').html("");
    }

    if ($('#email').val() == "") {
        $('#email_error').html("Må legge inn epost.");
        formOK = false;
    } else {
        $('#email_error').html("");
    }
    if (withPass) {
        if ($('#password').val().length < 6) {
            $('#password_error').html("Passordet må være minst 6 tegn langt.");
            formOK = false;
        } else {
            $('#password_error').html("");
        }   
    }


    // submit if all is OK    
    if (formOK) {$('#userForm').submit();}
}