<?php 
    require_once "../../vendor/autoload.php";
    use app\classes\AuthChecker;
    use app\classes\Tickets;

    $auth = new AuthChecker;
    $ticket = new Tickets;


    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        echo json_encode($ticket->graphsList());
    }
?>