<!DOCTYPE html>
<html>
<?php
require '../functions/function.php';
require '../functions/head.php';

if ($_SESSION["clearance"] == "Admin") {
    header("Location: ../frontend/dashboard.php");
    exit();
} elseif (!isset($_SESSION['id']) || $_SESSION['id'] == 0) {
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

<body>
    <h1 class="text-center mb-5">News</h1>
    <div class="container text-center">
        <div class="row" id="NewsDataContainer">
            <!-- Content will be rendered here -->
        </div>
    </div>
    <style>
        .img-corner {
            border-radius: 8px; 
        }
    </style>
    <!-- Modal -->
    <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newsModalLabel">News Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <img id="modalImage" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <h5 id="modalTitle" class="card-title"></h5>
                                <p id="modalContent"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var NewsData;

        const showModal = (index) => {
            const img = NewsData[index]['image'];
            const title = NewsData[index]['title'];
            const content = NewsData[index]['content'];

            $("#modalImage").attr("src", img);
            $("#modalTitle").text(title);
            $("#modalContent").html(content);

            $("#newsModal").modal("show");
        }

        $(document).ready(function() {
            $.getJSON("../backend/news.json", function(data) {
                NewsData = data;
                let NewsDataHTML = "";

                for (let x in NewsData) {
                    const img = NewsData[x]['image'];
                    const title = NewsData[x]['title'];
                    const content = NewsData[x]['content'];

                    const trimmedContent = content.split(' ').slice(0, 50).join(' ');
                    const remainingContent = content.split(' ').slice(50).join(' ');

                    NewsDataHTML += `
                        <div class="container-xxl">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="img-corner" src="${img}" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title">${title}</h5>
                                    <p id="content-${x}">${trimmedContent}</p>
                                    <button onclick="showModal(${x})" class="btn btn-primary">Read More</button>
                                    <p id="fullContent-${x}" style="display: none;"></p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    `;

                    $(`#fullContent-${x}`).text(remainingContent);
                }

                $("#NewsDataContainer").html(NewsDataHTML);
            });
        });
    </script>
</body>
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