<?php

require_once "./vendor/autoload.php";

use app\classes\Tickets;
$tickets = new Tickets;

    // if($_SERVER['REQUEST_METHOD'] === 'GET'){
    //     echo json_encode($tickets->list());
    // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAMPLE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5 mb-5">
        <table class="table table-striped table-hover" id="tickets_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
        
            </tbody>
        </table>    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            let table = $('#tickets_table');
            let tRow = 0;
            let initialRowVal = 10;
            const ticketUrl = './app/controls/TicketsController.php';

            const showAllTickets = (tickets) => {
                console.log(tickets.length);
                tickets.map(ticket => {
                    table.append('<tr>'+'<td>'+ ticket.TICKET_NAME + '</td>'+'<td>'+ ticket.TICKET_DESCRIPTION + '</td>'+ '<td>'+ ticket.TYPE_NAME + '</td>'+'</tr>')
                })
            }

            const calcPage = row => {
                return Math.round(row/initialRowVal);
            }

            const showPage = (rows) => {
                let
            }
            // const calcRow = 

            const getApi = (url) => {
                fetch(url,{
                    method: 'GET',
                    headers: {"Content-type": "application/json;charset=UTF-8"}
                })
                .then(response => response.json())
                .then(data => {
                    showAllTickets(data);
                })
                .catch(err => {
                    return err;
                })
            }


            getApi(ticketUrl);
            console.log(calcPage(77));
        });
    </script>

</body>
</html>