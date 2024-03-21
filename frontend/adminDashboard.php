<!DOCTYPE html>
<html>
<?php
require_once '../backend/dbconfig.php';
require '../functions/function.php';
require '../functions/headAdmin.php';
if (isset($_SESSION['id']) == null || 0 || ["clearance"] == "User") {
    echo 'YOU HAVE NO ACCESS';
    header('location: ./login.php');
}

?>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Noxmourth</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <?php include '../components/navbar.php'; ?>
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
    <section id="usersDatabase">
        <div class="container">
            <h1 class="text-center mb-5">Users List</h1>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Clearance</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="content">
                    <!-- User data will be populated here -->
                </tbody>
            </table>
            <div class="container">
                <!-- Back Button -->
                <a href="./dashboard.php" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="modal fade" id="modalUsers" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTitle">Update User Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="userForm">
                            <div class="form-outline form-dark mb-4">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control form-control" />
                                <small class="text-danger ml-5" id="nameError"></small>
                            </div>
                            <div class="form-outline form-dark mb-4">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control form-control" />
                                <small class="text-danger ml-5" id="usernameError"></small>
                            </div>
                            <div class="form-outline form-dark mb-4">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control form-control" />
                                <small class="text-danger ml-5" id="emailError"></small>
                            </div>
                            <div class="form-outline form-dark mb-4">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-dark px-5" id="saveUser"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <section id="newsWriting">
        <div class="container-xl">
            <h1 class="text-center mb-5">News Writing</h1>
            <form id="uploadNews" action="" autocomplete="off" method="POST" enctype="multipart/form-data">
                <label class="form-label" for="">Choose a file:</label>
                <input class="form-control" type="file" name="pict" id="pict" required><br>
                <label class="form-label" for="">Title For The News:</label>
                <input class="form-control" type="text" name="title" id="title" required><br>
                <label class="form-label" for="">Write The News:</label>
                <textarea class="form-control" type="text" name="news" id="news" rows="4" cols="50" required></textarea><br>
                <button class="btn btn-primary btn-block mb-4" type="button" id="submitNews">Submit</button>
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
                <h5 id="previewTitle"></h5>
                <p id="previewContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

    </section>

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

    <section id="galleryHandle">
  <div class="container-sm">
    <div class="row">
      <div class="col">
        <div class="container-xl">
          <h1 class="text-center mb-5">Gallery Addition</h1>
          <form id="uploadGallery" action="../functions/galleryHandling.php" autocomplete="off" method="POST" enctype="multipart/form-data">
            <label class="form-label" for="">Choose a file:</label>
            <input class="form-control" type="file" name="gallery[]" id="gallery" multiple required><br>
            <label class="form-label" for="">Title For The Gallery</label>
            <input class="form-control" type="text" name="titleGallery" id="titleGallery" required><br>
            <button class="btn btn-primary btn-block mb-4" type="submit" id="submitGallery">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
                <!-- Back Button -->
                <a href="./dashboard.php" class="btn btn-secondary btn-block mb-4">Back</a>
            </div>
</section>

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