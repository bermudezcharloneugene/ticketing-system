
<?php include_once '../layouts/protected/header.php'; ?>



    <div class="container mt-5">
        <div class="mb-5 text-center">
            <h3 class="f1">Change Password</h3>
        </div>

        <form action="" class="login-container">
            <div class="alert alert-danger d-none" id="errorBox" role="alert"></div>
            <div class="form-group">
                <input type="password" id="old-password" class="form-control" placeholder="Old Password">
            </div>
            <div class="form-group">
                <input type="password" id="new-password" class="form-control" placeholder="New Password">
            </div>
            <div class="form-group">
                <input type="password" id="confirm-password" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-block btn-primary" id="btnChangePass" >Change Password</button>
            </div>
        </form>
    </div>

<?php include_once '../layouts/protected/scripts.php'; ?>

    <script>
        $(document).ready(function() {
            $('#btnChangePass').on('click', function(e) {
                e.preventDefault();
                let old_password = $('#old-password').val();
                let new_password = $('#new-password').val();
                let confirm_password = $('#confirm-password').val();
                let errorBox = $('#errorBox');
                $.ajax({
                    url: '../../app/controls/ChangePasswordController.php',
                    method: 'POST',
                    data: {old_password: old_password, new_password: new_password, confirm_password: confirm_password},
                    dataType: "JSON",
                    beforeSend: function(data){
                        errorBox.empty();
                        $('#btnChangePass').attr('disabled', 'true');
                    },
                    success: function(data) {
                        alert('Password change success!')
                        setTimeout(function(){ 
                        window.location.reload(1);
                        }, 500);

                    },
                    error: function(data) {
                        $('#btnChangePass').removeAttr('disabled');
                        $('#errorBox').removeClass('d-none');
                        const errorMsg = toJson(data.responseJSON.errorMessage);
                        $.each(errorMsg, function(key, value) {
                            errorBox.append('<div>'+ value + '</div>');
                        })
                    }
                })

            })

            const toJson = (params) => {
                let string = JSON.stringify(params);
                let parseData = JSON.parse(string);
                return parseData;
            }
        });
    </script>


<?php include_once '../layouts/protected/footer.php'; ?>