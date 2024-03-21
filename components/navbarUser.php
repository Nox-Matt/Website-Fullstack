<?php
@$id = $_SESSION["id"];
if (isset($_SESSION["id"])) {
    global $conn;
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name,username FROM users WHERE id = $id"));
} else {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        $("#staticBackdrop").modal("show");
    });
</script>';
    error_reporting(E_ERROR | E_PARSE);
}
?>
<link rel="stylesheet" href="../functions/style.css">
<nav style="background-color:#333"class="navbar navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="brand navbar-brand space" href="../index.php">
            <img class="controller"
                src="../img/Noxmourth.png" alt="Logo"
                width="30" height="24" class="d-inline-block align-text-top">&nbspWelcome Back!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
            aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                    <?php
                    if (isset($_SESSION["id"]) == null || 0) {
                        echo "YOU HAVE NO ACCESS";
                    } else {
                        echo "Welcome Back  " . $user["name"] . " !";
                    }
                    ?>
                    <hr>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../frontend/indexUser.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../frontend/gallery.php">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../frontend/news.php">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="account.php" role="button">
                            Account
                        </a>
                        <ul class="menu-dark">
                            <li><a class="dropdown-item" href="#">Change Name</a></li>
                            <li><a class="dropdown-item" href="#">Change Password</a></li>
                            <li><a class="dropdown-item" href="../functions./logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
