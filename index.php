
<?php include_once __DIR__ . '\views\layouts\header.php' ?>

    <form class="login-container" action="" method="post" id="login_form">
        <div class="text-center mt-5 mb-5 logo">
            <i style="font-size: 130px" class="fas fa-ticket-alt"></i>
        </div>
        <div class="text-center mt-5">
            <div class="lds-ring d-none">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="text-center mt-5 mb-5">
            <h1>Ticketing System</h1>
        </div>
        <div class="alert alert-danger d-none" role="alert" id="errorBoxLogin">

        </div>
        <input type="email" placeholder="Email" name="email" id="email_login" class="form-control" >
        <input type="password" placeholder="Password" name="password" id="password_login" class="form-control" >
        <div class="mt-3">
            <button type="submit" class="btn btn-primary btn-block" id="loginBtn">Submit</button>
            <div class="mt-3 text-center">
                <a href="./register.php">Register</a>
            </div>
        </div>
    </form>


<?php include_once __DIR__ . '\views\layouts\footer.php' ?>

