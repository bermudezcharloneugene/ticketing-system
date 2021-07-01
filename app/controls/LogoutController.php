<?php 

require_once "../../vendor/autoload.php";
use app\classes\AuthChecker;
use app\utils\Utility;
use app\utils\Session;

$auth = new AuthChecker;
$session = new Session;

$session->closeSession();

if(session_status() == PHP_SESSION_NONE){
    Utility::redirect('../../index.php');
}


?>