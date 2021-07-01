<?php 
    require_once "../../vendor/autoload.php";

    use app\classes\Register;

    $reg = new Register;

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        echo $reg->register();
    }
?>