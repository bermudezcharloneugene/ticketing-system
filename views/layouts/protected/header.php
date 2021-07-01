<?php
    require_once "../../vendor/autoload.php";
    use app\classes\AuthChecker;
    use app\classes\Profiles;
    $auth = new AuthChecker;
    $profiles = new Profiles;
    $profile_path = $profiles->getUserProfilePath($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">

    <link rel="stylesheet" href="../../public/css/index.css?ver=7.2">
</head>
<body>

<div class="d-flex" id="wrapper">
    <div class="sidebar border-right">
        <div class="sidebar-heading">
            <a href="./settings.php"><img id="img-prev" class="image-profile" src="<?= $profile_path != '' ? '../../public/assets/images/' . $profile_path : 'https://via.placeholder.com/150';?>" 
            alt="profile image"></a>
            <p class="text-center"><?php if(isset($_SESSION['name'])) {
                echo $_SESSION['name'];
            } ?></p>
        </div>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action side-bar-link" href="http://localhost/ticketing_system2/views/protected/home.php"><i class="fas fa-home"></i> Home</a>
            <a class="list-group-item list-group-item-action side-bar-link" href="http://localhost/ticketing_system2/views/protected/dashboard.php"><i class="fas fa-tachometer-alt"></i> Analytics</a>
            <a class="list-group-item list-group-item-action side-bar-link" href="http://localhost/ticketing_system2/views/protected/list.php"><i class="ico fas fa-clipboard-list"></i> List</a>
            <a class="list-group-item list-group-item-action side-bar-link" href="http://localhost/ticketing_system2/views/protected/profiles.php"><i class="fas fa-user"></i> Profiles</a>
            <a class="list-group-item list-group-item-action side-bar-link" href=""><i class="fas fa-trash-alt"></i> Trash</a>
            
        </div>
    </div>
    <div class="main-page">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><i class="fas fa-ticket-alt"></i> Ticketing System</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if(isset($_SESSION['name'])){echo $_SESSION['name']; } ?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" id="logout" href="../../app/controls/LogoutController.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>