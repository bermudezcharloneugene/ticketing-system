<?php require_once __DIR__ . '\views\layouts\header.php' ?>
    <div class="mt-5 container w">
        <div class="mb-5 text-center">
            <h3>Ticketing System Registration</h3>
        </div>
        <div class="alert alert-danger d-none" role="alert" id="errorBoxRegister">

        </div>
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" >
                    <div class="form-group">
                      <label for="">Name</label>
                      <input type="text" name="name" id="name" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                      <label for="">Email</label>
                      <input type="text" name="email" id="email" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                      <label for="">Password</label>
                      <input type="password" name="password" id="password" class="form-control" placeholder="" aria-describedby="helpId">
                      <small id="helpId" class="text-muted">8 characters minimum. Alpha-numeric characters</small>
                    </div>
                    <div class="form-group">
                      <label for="">Confirm Password</label>
                      <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="mt-3">
                        <input id="register" type="button" class="btn btn-block btn-primary" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '\views\layouts\footer.php' ?>