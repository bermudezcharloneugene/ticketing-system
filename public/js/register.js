$(document).ready(function(){
    $('#register').on('click', function(e){
        e.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        let errorBox = $('#errorBoxRegister');

        $.ajax({
            url: './app/controls/RegistrationController.php',
            type: 'POST',
            data: {
                name: name,
                email: email,
                password: password,
                confirm_password: confirm_password
            },
            beforeSend: function(data) {
                if(!errorBox.hasClass('d-none')){
                    errorBox.addClass('d-none');
                }
                $(this).attr('disabled', 'true');
                errorBox.empty();
            },
            success: function(data) {

                alert('Registered Successfully');
                setTimeout(function(){ 
                    window.location.replace("http://localhost/ticketing_system2/index.php"); // WILL REPLACE THIS
                }, 500);
            },
            error: function(data) {
                let results = JSON.parse(data.responseText);
                $(this).removeAttr('disabled');
                errorBox.removeClass('d-none');
                $.each(results.errorMessage, function(key, value) {
                     errorBox.append('<div>'+ value + '</div>');
                }) 
            }, 
        });
    });

});