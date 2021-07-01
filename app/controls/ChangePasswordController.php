 <?php 
    require_once "../../vendor/autoload.php";
    use app\classes\AuthChecker;
    use app\classes\ChangePassword;

    $auth = new AuthChecker;
    $userCred = new ChangePassword;


    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        echo $userCred->index();
    }
?>