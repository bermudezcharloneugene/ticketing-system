<?php 

require_once "../../vendor/autoload.php";

use app\classes\Login;

$login = new Login;

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $login->login();
}

?>