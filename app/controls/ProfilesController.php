<?php 
    require_once "../../vendor/autoload.php";
    use app\classes\AuthChecker;
    use app\classes\Profiles;

    $auth = new AuthChecker;
    $profiles = new Profiles;

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        echo $profiles->update();
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        echo $profiles->userList();
    }
?>