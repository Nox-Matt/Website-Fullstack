<!DOCTYPE html>
<html>
<?php
require '../functions/function.php';
require '../functions/headAdmin.php';
if ($_SESSION["clearance"] == "User") {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        $("#staticBackdrop").modal("show");
    });
</script>';
}
elseif(isset($_SESSION['id']) == null || 0){
    echo 'YOU HAVE NO ACCESS';
    header('location: ./login.php');
}
?>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Noxmourth</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php
    if($_SESSION["clearance"] == "SuperAdmin"){
        include '../components/navbarSuperAdmin.php';
    }
    else{
        include '../components/navbar.php';
    } ?>
</head>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<body>
    <div class="container-md">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card text-bg-light">
                    <?php if ($_SESSION['clearance'] == "SuperAdmin"): ?>
                        <a class="scroll-link" href="./superAdminDashboard.php#usersDatabase">
                    <?php else: ?>
                        <a class="scroll-link" href="./adminDashboard.php#usersDatabase">
                    <?php endif; ?>
                        <img src="../img/Database.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Users Dashboard</h5>
                        <p class="card-text">Maintain User Database In This Window</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-light">
                    <a class="scroll-link" href="./adminDashboard.php#newsWriting">
                        <img src="../img/News.jpg" class="card-img-top" alt="...">
                    </a>
                    <div style="display: block;
                                margin-bottom: 1em;" class="card-body">
                        <h5 class="card-title">News Writing</h5>
                        <p class="card-text">Write Upcoming News Article For The User</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-light">
                    <a class="scroll-link" href="./adminDashboard.php#galleryHandle">
                        <img style="height:18.9em;" src="../img/GalleryCheck.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <div style="display: block;
                                margin-bottom: 1em;"></div>
                        <h5 class="card-title">Gallery Handling</h5>
                        <p class="card-text">Settings The Gallery For Users To See</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-light">
                    <a class="scroll-link" href="./newsDatabase.php">
                        <img src="../img/NewsDatabase.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <div style="display: block;
                                margin-bottom: 1em;"></div>
                        <h5 class="card-title">News Database</h5>
                        <p class="card-text">News Database For Checking Up News</p>
                    </div>
                </div>
            </div>
            <div class="col"></div>
            <div class="col">
                <div class="card text-bg-light">

                    <a class="scroll-link" href="./galleryDatabase.php">
                        <img src="../img/GalleryDatabase.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Gallery Database</h5>
                        <p class="card-text">Gallery Database For Handling Gallery Items</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

</body>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Uh Oh!</h1>
                <button onclick="window.location.href='./login.php'" type="button" class="btn-close"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p> You Have No Access</p>
            </div>
            <div class="modal-footer">
                <button onclick="window.location.href='./login.php'" type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<footer class="bg-dark text-center text-white">
<?php include("../components/footer.php"); ?>
</footer>

</html>