<?php 
    require_once "../../vendor/autoload.php";
    use app\classes\AuthChecker;
    use app\classes\FileHandler;

    $auth = new AuthChecker;
    $file = new FileHandler;


    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
       echo $file->handleFile();
    }