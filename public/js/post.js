

$(document).ready(function (e) {

    $('#postTicket').on('click', function(e) {
        e.preventDefault();
        var ticket_name = $('#ticket_name').val();
        var ticket_description = $('#ticket_description').val();
        var root_cause = $('#root_cause').val();
        var solution = $('#solution').val();
        var remarks = $('#remarks').val();
        var errorBox = $('#errorBox');

        $.ajax({
            url: "../../app/controls/HomeController.php",
            method: "POST",
            dataType: "JSON",
            data: {ticket_name: ticket_name, ticket_description: ticket_description, root_cause, solution, remarks},
            beforeSend: function(data){
                errorBox.empty();
                $('#postTicket').attr('disabled', 'true');

            },
            success: function(data, textStatus, xhr) {
                setTimeout(function() {
                    $('#postTicket').removeAttr('disabled');
                }, 1000)
                console.log(textStatus);
                // setTimeout(function(){ 
                //     window.location.reload(1);
                // }, 3000);
                
            },
            error: function(data) {
                $('#postTicket').removeAttr('disabled');
                let errorMsg = toJSON(data.responseJSON[0]);
                errorBox.removeClass('d-none');
                $.each(errorMsg.errorMessage, function(key, value) {
                     errorBox.append('<div>'+ value + '</div>');
                })
            }
        });
    })

    function showError(msg){
        alert(msg)
    }

    function toJSON(params)
    {
        let string = JSON.stringify(params);
        let parseData = JSON.parse(string);
        return parseData;
    }

    function errorText($arr)
    {
        $res = "div" + $arr + "</div>";
        return $res;
    }


})