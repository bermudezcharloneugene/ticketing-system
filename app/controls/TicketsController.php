<?php

    require_once "../../vendor/autoload.php";
    use app\classes\Tickets;                   
    $ticket = new Tickets;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_method']))
    {
        switch ($_POST['request_method']) {
            case "DELETE":
                echo $ticket->delete($_POST['id']);
            break;

            case "PUT":
                echo $ticket->update($_POST['id']);
            break;

            default: 
            echo $ticket->create();
        }
    }


    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if(isset($_GET['id']))
        {
            echo json_encode($ticket->byId($_GET['id']));
        }else {
            echo json_encode($ticket->list());
        }
        
    }

?>