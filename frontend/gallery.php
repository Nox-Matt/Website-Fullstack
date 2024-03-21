<!DOCTYPE html>
<html>
<?php
require '../functions/function.php';
require '../functions/head.php';
if ($_SESSION["clearance"] == "Admin") {
    header("Location: ../frontend/dashboard.php");
    exit();
} elseif (isset($_SESSION['id']) == null || 0) {
    echo 'YOU HAVE NO ACCESS';
    header('location: ./login.php');
    exit();
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
<br>
<br>
<body>
<h1 class="text-center mb-5">Gallery</h1>
    <div class="container text-center">
        <div class="row" id="galleryContainer">
            <!-- Content will be rendered here -->
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
            const getGalleryData = () => {
                const url = "../backend/gallery_data.php";
                let galleryHTML = "";
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function(galleryData) {
                        for (let x in galleryData) {
                            const img = galleryData[x]['img'];
                            const title = galleryData[x]['tittle'];
                            galleryHTML += `
                            <div class="col">
                                <div class="card text-bg-dark" style="width: 18rem;">
                                    <img src="${img}" class="card-img-top" alt="Image" style="width: 17.9rem; height: 18rem;">
                                    <div class="card-img-overlay">
                                        <h5 class="card-title">${title}</h5>
                                    </div>
                                </div>
                            <br>
                            <br>
                            </div>
                            `;
                        }
                        $("#galleryContainer").html(galleryHTML);
                    }
                });
            }

            getGalleryData();
        });
</script>
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