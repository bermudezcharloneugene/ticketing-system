<?php require_once '../layouts/protected/header.php'; ?>

    <div class="container mt-5">
        <table class="table table-striped" id="list_table">
            <thead class="thead-dark">
                <th>Name</th>
                <th>Role</th>
                <th>Action</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

<?php include_once '../layouts/protected/scripts.php'; ?>

    <script>
        $(document).ready(function () {
            var table = $('#list_table').DataTable({
               "ajax": {
                   "url": "../../app/controls/ProfilesController.php",
                   "dataSrc": ""
               },
               "columns": [
                   {"data": "NAME"},
                   {"data": "ROLE_NAME"},
                   {"data": "USER_ID", render: function(data, type, row)
                    {
                        return '<div class="form-check"><input class="form-check-input" type="checkbox" value="" id="update_role"><label class="form-check-label" for="update_role">Is admin?</label></div>'
                    }
                   },
               ]
            });
        });

    $(function() {
	    $(document).on('change', '[name="user_role"]' , function(){
  	        var user_role = $('[name="user_role"]:checked').val();
            let user_id = $(this).parent().children('#user_id').val();
            if(confirm('This will change the user role?')) {
                console.log(user_role);
                console.log(user_id);
                $.ajax({
                    url: '../../app/controls/ProfilesController.php',
                    method: 'POST',
                    data: {user_role: user_role, user_id: user_id},
                    beforeSend: function(data){
                    },
                    success: function(data) {
                        console.log(data)
                    },
                    error: function(data){
                        console.log(data);
                    }
                })
            }
        }); 
    });
    </script>
<?php include_once '../layouts/protected/footer.php'; ?>