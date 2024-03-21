<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php require '../functions/head.php';
require_once '../backend/dbconfig.php';
?>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-7">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-6">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <form id="formlogin" autocomplete="off" action="" method="POST">
                                        <input class="form-control" type="hidden" id="action" value="login">
                                        <h2>Login</h2>
                                        <hr>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="">Username</label>
                                            <input class="form-control" type="text" id="username" value=""><br>
                                        </div>
                                        <div>
                                            <label class="form-label" for="">Password</label>
                                            <input class="form-control" type="password" id="password" value=""><br>
                                        </div>
                                        <button class="btn btn-primary btn-block mb-4" type="button"
                                            onclick="submitData();">Login</button>
                                    </form>
                                    <br>
                                    <a href="./register.php">Don't Have an Account? Register Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Uh Oh!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="alert">Alert Goes Here</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="staticBackdropSuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Well Done!</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="loginResponse">Login Successful !</p>
            </div>
            <div class="modal-footer">
                <button onclick="window.location.href='./indexUser.php'" type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Continue</button>
            </div>
        </div>
    </div>
</div>

</html>