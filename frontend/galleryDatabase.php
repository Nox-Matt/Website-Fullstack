<!DOCTYPE html>
<html>
<?php
require_once '../backend/dbconfig.php';
require '../functions/function.php';
require '../functions/headAdmin.php';
if (isset($_SESSION['id']) == null || $_SESSION['clearance'] == "User") {
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
    <h1 class="text-center mb-5">Gallery</h1>
    <div class="container text-center">
        <div class="row" id="galleryContainer">
            <!-- Gallery content will be rendered here -->
        </div>
    </div>

    <!-- Modal for updating and deleting gallery items -->
    <div class="modal fade" id="modalGallery" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTitle">Update Gallery Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="POST" id="galleryForm">
                        <div class="form-outline form-dark mb-4">
                            <input type="hidden" name="galleryId" id="galleryId" value="">
                            <label class="form-label" for="titleGallery">Title</label>
                            <input type="text" name="titleGallery" id="titleGallery" class="form-control form-control" />
                            <small class="text-danger ml-5" id="titleError"></small>
                        </div>
                        <div class="form-outline form-dark mb-4">
                            <label class="form-label" for="imageGallery">Image</label>
                            <input type="file" name="imageGallery" id="imageGallery" class="form-control form-control" />
                            <small class="text-danger ml-5" id="imageError"></small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-dark px-5" id="saveGallery">Save</button>
                </div>
            </div>
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
                        const id = galleryData[x]['id'];
                        const img = galleryData[x]['img'];
                        const title = galleryData[x]['tittle'];
                        galleryHTML += `
                            <div class="col">
                                <div class="card text-bg-dark" style="width: 18rem;">
                                    <img src="${img}" class="card-img-top" alt="Image" style="width: 17.9rem; height: 18rem;">
                                    <div class="card-img-overlay">
                                        <h5 class="card-title">${title}</h5>
                                        <button class="btn btn-warning editButton" data-id="${id}" data-bs-toggle="modal" data-bs-target="#modalGallery">Edit</button>&nbsp;
                                        <button class="btn btn-danger deleteButton" data-id="${id}">Delete</button>
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

        $(document).on("click", ".editButton", function () {
            const id = $(this).data("id");
            console.log("Edit ID:", id);
            $("#galleryId").val(id);

            const data = {
                action: "getById",
                id: id,
            };

            $.ajax({
                type: "POST",
                url: "../backend/gallery_data.php",
                data: data,
                dataType: "json",
                success: function (galleryData) {
                    console.log("Retrieved Gallery Data:", galleryData);

                    if (galleryData.hasOwnProperty("id") && galleryData.hasOwnProperty("title") && galleryData.hasOwnProperty("img")) {
                        // Populate form fields with existing data
                        $("#titleGallery").val(galleryData.title);
                        $("#imageGallery").val(galleryData.img);
                    } else {
                        console.log("Gallery data not found for ID: " + id);
                    }
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });

        $("#modalGallery").on("click", "#saveGallery", function () {
    const id = $("#galleryId").val();
    const title = $("#titleGallery").val();
    const formData = new FormData($("#galleryForm")[0]);

    formData.append("action", "update");
    formData.append("id", id);
    formData.append("title", title);

    $.ajax({
        type: "POST",
        url: "../backend/gallery_data.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.status === "OK") {
                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: "success",
                });
                getGalleryData();
                clearFormFields();
                $("#modalGallery").modal("hide");
            } else {
                Swal.fire({
                    title: "Error",
                    text: response.message,
                    icon: "error",
                });
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
});


        $(document).on("click", ".deleteButton", function () {
            const id = $(this).data("id");

            Swal.fire({
                title: "Are you sure you want to delete this gallery item?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../backend/gallery_data.php",
                        data: {
                            action: "delete",
                            id: id,
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response.status === "OK") {
                                Swal.fire({
                                    title: response.title,
                                    text: response.message,
                                    icon: "success",
                                });
                                getGalleryData();
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error",
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
                }
            });
        });

        const clearFormFields = () => {
            $("#titleGallery").val("");
            $("#imageGallery").val("");
        };

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
