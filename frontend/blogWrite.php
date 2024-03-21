<!DOCTYPE html>
<html>
<?php
require '../functions/function.php';
require '../functions/head.php';
$user_id = $_SESSION['id'];

if (isset($_SESSION['id']) == null || 0){
    echo 'YOU HAVE NO ACCESS';
    header('location: ./login.php');
}
?>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Noxmourth</title>
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
    <div class="container-xl">
    <h1 class="text-center mb-5">Blog Writing</h1>
        <form id="upload" action="" autocomplete="off" method="POST" enctype="multipart/form-data">
        <input style="display: none;" class="form-control" type="number" name="id" id="id" value="<?php echo $user_id; ?>"></input>
            <label class="form-label" for="">Choose a file:</label>
            <input class="form-control" type="file" name="file" id="file" required><br>

            <label class="form-label" for="">Write something:</label>
            <textarea class="form-control" name="content" id="content" rows="4" cols="50" required></textarea><br>

            <button class="btn btn-primary btn-block mb-4" type="button" id="submitUserData">Submit</button>
            <button type="button" class="btn btn-primary btn-block mb-4" data-toggle="modal" data-target="#previewModal">
                See Preview Content
            </button>
        </form>
    </div>
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel"aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Preview Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="previewImage" src="" alt="Preview Image" class="img-fluid mt-1">
                <p id="previewContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
        <div class="container">
                <!-- Back Button -->
                <a href="./indexUser.php" class="btn btn-secondary btn-block mb-4">Back</a>
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