<!DOCTYPE html>
<html>
<?php
require '../functions/function.php';
require '../functions/head.php';
if ($_SESSION["clearance"] == "Admin") {
    header("Location: ../frontend/dashboard.php");
}
elseif(isset($_SESSION['id']) == null || 0){
  echo 'YOU HAVE NO ACCESS';
  header('location: ./login.php');
}
?>
<head>
<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Blogspots</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php include '../components/navbarUser.php'; ?>
</head>
<style>
  .hide {
  display: none;
}

.show {
  display: block;
}
</style>
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
<body>
<div class="container text-center">
<h1>Blogs</h1>
<br>
  <div class="row" id="contentBlog">
    <!-- Dynamic content will be inserted here -->
  </div>
</div>
<br>
<br>
</body>
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
<script>
    $(document).ready(function() {
        $.getJSON("../backend/content.json", function(data) {
            let contentHTML = "";

            for (let i = 0; i < data.length; i++) {
                const title = data[i].title;
                const content = data[i].content;
                const img = data[i].image;

                const trimmedContent = content.split(' ').slice(0, 50).join(' ');
                const remainingContent = content.split(' ').slice(50).join(' ');

                contentHTML += `
                    <div class="col">
                        <div class="card">
                            <img src="${img}" class="card-img-top" alt="Image">
                            <div class="card-body">
                                <p class="card-text">${trimmedContent}</p>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-${i}">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal-${i}" tabindex="-1" role="dialog" aria-labelledby="modal-${i}-title" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <img src="${img}" class="card-img-top" alt="Image">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>${content}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }

            $("#contentBlog").html(contentHTML);
        });
    });
</script>
<footer class="bg-dark text-center text-white">
<?php include("../components/footer.php"); ?>
</footer>

</html>