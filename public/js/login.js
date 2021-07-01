$(document).ready(function(){
    $('#login_form').on('submit', function(e){
        e.preventDefault();

        var email = $('#email_login').val();
        var password = $('#password_login').val();
        var loader = $('.lds-ring');
        var loginBtn = $('#loginBtn');
        var logo = $('.logo');
        var errorBox = $('#errorBoxLogin');

        $.ajax({
            url: './app/controls/LoginController.php',
            method: 'POST',
            data: {email: email, password: password},
            beforeSend: function(data) {
                if(!errorBox.hasClass('d-none')){
                    errorBox.addClass('d-none');
                }
                loader.removeClass('d-none')
                logo.addClass('d-none')
                loginBtn.attr('disabled', 'true');
                errorBox.empty();
            },
            success: function(data) {
                window.location = './views/protected/home.php';
            },
            error: function(data) {
                let results = JSON.parse(data.responseText);
                loginBtn.removeAttr('disabled');

                errorBox.removeClass('d-none');
                $.each(results.errorMessage, function(key, value) {
                     errorBox.append('<div>'+ value + '</div>');
                }) 

                if(!loader.hasClass('d-none')){
                    loader.addClass('d-none')
                }
                if(logo.hasClass('d-none'))
                {
                    logo.removeClass('d-none');
                }
                
            }
        })
    });
});