<!DOCTYPE html>
<html>
<?php
require '../functions/function.php';
require '../functions/head.php';
if ($_SESSION["clearance"] == "Admin" || $_SESSION["clearance"] == "SuperAdmin") {
    header("Location: ../frontend/dashboard.php");
}
elseif (isset($_SESSION['id']) == null || 0){
    echo 'YOU HAVE NO ACCESS';
    header('location: ./login.php');
}
?>


<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Welcome!</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php include '../components/navbarUser.php'; ?>
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
                    <a href="./blogWrite.php">
                        <img src="../img/Blog.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Write a Blog</h5>
                        <p class="card-text">Having the urge to write? Tell everyone what's on your mind in words!
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-light">
                    <a href="./content.php">
                        <img src="../img/SeeBlog.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Check Your Blog</h5>
                        <p class="card-text">Feel something can be added? to your blogs? Edit them here to make it
                            look
                            perfect! </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-light">
                    <a href="./globalBlog.php">
                        <img src="../img/Community.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <div style="margin-bottom: 146px;"></div>
                        <h5 class="card-title">See Other People's Blog</h5>
                        <p class="card-text">Are you looking for inspiration or interested in exploring the creative
                            works of others? Join the community today!</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-light">
                    <a href="./gallery.php">
                        <img src="../img/Gallery.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <div style="margin-bottom: 76px;"></div>
                        <h5 class="card-title">See Other People's Picture</h5>
                        <p class="card-text">Wanting to see what other's people do this days? Check the library to
                            see
                            picture posted by other people!.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-light">
                    <a href="./news.php">
                        <img style="height:19em"src="../img/Custom.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">News Reading</h5>
                        <p class="card-text">Read the lastest news and give out your opinion later in your own blog!</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-bg-light">
                    <a href="./aboutUs.php">
                        <img src="../img/AboutUs.jpg" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">About Us</h5>
                        <p class="card-text">Discover more about our organization and the range of services we offer. Click Here to learn about us and what we do!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

</body>
<!-- Modal -->
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
<br>
<br>
<br>
<br>
<br>
<footer class="bg-dark text-center text-white">
<?php include("../components/footer.php"); ?>
</footer>

</html>