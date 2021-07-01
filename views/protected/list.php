
<?php include_once '../layouts/protected/header.php'; ?>

    <div class="my-5 mx-5">
        <div class="table-responsive">
            <table id="list_table" class="table table-hover" width="3500">
                <thead class="thead-dark text-center">
                    <tr>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Root Cause</th>
                        <th>Solution</th>
                        <th>Remarks</th>
                        <th>Reported Date</th>
                        <th>Programmer</th>
                        <th>QA</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body" >
                    <div class="alert alert-danger d-none" id="errorBox" role="alert"></div>
                    <form action="" id="modalEdit">
                    
                    </form>
                </div>

            </div>
        </div>
    </div>
   
<?php include_once '../layouts/protected/scripts.php'; ?>

    <script>
        $(document).ready( function () {
            
           var table = $('#list_table').DataTable({
                    responsive: true,
                
               "ajax": {
                   "url": "../../app/controls/TicketsController.php",
                   "dataSrc": ""
               },
               "columns": [
                //    { "className": "d-none", "data": "TICKET_ID"},
                   {"data": "TICKET_NAME"},
                   {"data": "TICKET_STATUS_NAME", render: function(data, type, row)
                    {   
                        if(data === 'open')
                        {
                            return '<p class="text-truncate" style="background: green; color: white; font-size: 12px; text-align: center; text-transform: uppercase;">'+row.TICKET_STATUS_NAME+'</p>'

                        }else if(data === 'in-progress') {
                            return '<p class="text-truncate" style="background: orange; color: white; font-size: 12px; text-align: center; text-transform: uppercase;">'+row.TICKET_STATUS_NAME+'</p>'

                        }else if(data === 'closed') {
                            return '<p class="text-truncate" style="background: red; color: white; font-size: 12px; text-align: center; text-transform: uppercase;">'+row.TICKET_STATUS_NAME+'</p>'

                        }
                    }
                   },
                   {
                    "data": "TYPE_NAME"
                   },
                   {
                       "data": "TICKET_DESCRIPTION"
                   },
                   {
                       "data": "ROOT_CAUSE"
                   },
                   {
                       "data": "SOLUTION"
                   },
                   {
                       "data": "REMARKS"
                   },
                   {
                       "data": "CREATED_AT"
                   },
                   {
                       "data": "NAME"
                   },
                   {
                       "data": "NAME"
                   },
                   {"data": "TICKET_ID", render: function(data, type, row)
                    {
                        
                        return '<div class="text-center"><button onclick="showEditForm('+row.TICKET_ID+')" type="submit" class="btn btn-outline-primary update" value="PUT" id="edit"><i class="fas fa-edit"></i></button> <button type="button" class="btn btn-outline-danger delete" onclick="onDelete('+row.TICKET_ID+')" id="delete" value="DELETE"><i class="fas fa-trash"></i></i></button></div>'
                    }
                   },
               ]
           });
        });

        
        function onDelete(id)
        {
            // let del = document.getQuerySelector('.delete')
            let btn = document.querySelector('.delete');
            const method = btn.value;
            let errorBox = $('#errorBox');
            
            if(confirm('Are you sure you want to delete this record?'))
            {
                $.ajax({
                    url: "../../app/controls/TicketsController.php",
                    method: "POST",
                    data: {id: id, request_method: method},
                    dataType: "JSON",
                    success: function(data) {
                        alert('Record is deleted')
                        var table = $('#list_table').DataTable( {
                        }).ajax.reload ();
                        // setTimeout(function(){ 
                        //     window.location.reload(1);
                        // }, 3000);
                    },
                    error: function(data) {

                        // errorBox.removeClass('d-none');
                        // $.each(errorMsg.errorMessage, function(key, value) {
                        //      errorBox.append('<div>'+ value + '</div>');
                        // })
                    },
                })
            }
        }

        

        function showEditForm(id)
        {
            $('#editModal').modal('show');
            let btn = document.querySelector('.update');
            let method = btn.value;
            let modalEdit = $('#modalEdit');
            $.ajax({
                url: "../../app/controls/TicketsController.php?id="+id,
                method: "GET",
                // data: {id: id, request_method: method},
                beforeSend: function(data) {
                    modalEdit.empty();
                },
                success: function(data) {
                    var data = toJSON(data);
                    modalEdit.append(
                        '<div class="form-group">'+
                            '<label>Ticket Name</label>'+
                            '<input placeholder="Ticket Name" id="ticket_name" type="text" class="form-control ticket_name" value="' + data[0].TICKET_NAME + '" disabled/>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>Description</label>'+
                            '<textarea placeholder="Ticket Description" cols="30" rows="10" id="ticket_description" type="text" class="form-control ticket_description" value="" disabled>' + data[0].TICKET_DESCRIPTION + '</textarea>'+
                        '</div>'+
                        '<div>'+
                            '<input type="hidden" class="request_method" name="request_method" id="request_method" value="PUT" />'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label>Status</label>'+
                            '<input placeholder="Ticket Name" id="status_name" type="text" class="form-control status_name" value="' + data[0].TICKET_STATUS_NAME + '" disabled/>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label>Environment</label>'+
                            '<input placeholder="Ticket Name" id="status_name" type="text" class="form-control status_name" value="' + data[0].TICKET_ENVIRONMENT_NAME + '" disabled/>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<button type="button" onclick="update()" class="btn btn-primary btn-block updateForm" id="updateForm" value="' + data[0].TICKET_ID + '">Update</button>'+
                        '</div>'
                    )
                },

            })

        }

        function update() {
            let id = document.getElementById("updateForm").value;
            // let id = $(this).val();
            let request_method = document.getElementById("request_method").value;
            let ticket_description = document.getElementById('ticket_description').value;
            let ticket_name = document.getElementById('ticket_name').value;
            const errorBox = $('#errorBox');
            $.ajax({
                url: "../../app/controls/TicketsController.php",
                method: "POST",
                dataType: "JSON",
                data: {id: id, request_method: request_method, ticket_description: ticket_description, ticket_name: ticket_name},
                beforeSend: function(data) {
                    errorBox.empty();
                    if(!errorBox.hasClass('d-none'))
                    {
                        errorBox.addClass('d-none');
                    }
                },
                success: function(data) {
                    console.log(data);
                    setTimeout(function(){ 
                        window.location.reload(1);
                    }, 500);
                },
                error: function (data) {
                    // $('#postTicket').removeAttr('disabled');
                    let errorMsg = toJSON(data.responseText);
                    errorBox.removeClass('d-none');
                    console.log(errorMsg)
                    $.each(errorMsg[0].errorMessage, function(key, value) {
                         errorBox.append(value + `<br/>`);
                    })
                }
            })
        }
        


        function toJSON(params)
        {
            return JSON.parse(params);;
        }
        
    </script>

<?php include_once '../layouts/protected/footer.php'; ?>