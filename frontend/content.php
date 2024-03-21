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


<body>
    <div class="container">
        <h1 class="text-center mb-5">Blog List</h1>
        <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Content</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="contentBlog">
                <!-- User data will be populated here -->
                 </tbody>
        </table>
        <div class="container">
            <!-- Back Button -->
            <a href="./indexUser.php" class="btn btn-secondary">Back</a>
        </div>
    </div>
    <div class="modal fade" id="editBlog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalTitle">Blog Update</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../backend/blog_data.php" id="blogForm" enctype="multipart/form-data">
                    <div class="form-outline form-dark mb-4">
                        <label class="form-label" for="files">Image</label>
                        <input type="file" name="files" id="files" class="form-control form-control" readonly>
                        <small class="text-danger ml-5" id="filesError"></small>
                    </div>
                    <div class="form-outline form-dark mb-4">
                        <label class="form-label" for="content">Content</label>
                        <textarea type="text" name="content" id="content" class="form-control form-control"></textarea>
                        <small class="text-danger ml-5" id="contentError"></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-dark px-5" id="updateBlog">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
<footer class="bg-dark text-center text-white">
<?php include("../components/footer.php"); ?>
</footer>

</html>