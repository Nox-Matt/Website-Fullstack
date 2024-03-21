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
    <section>
        <div class="container">
            <h1 class="text-center mb-5">News Database</h1>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Image</th>
                        <th scope="col">Content</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="contentNews">
                    <!-- User data will be populated here -->
                </tbody>
            </table>
            <div class="container">
                <!-- Back Button -->
                <a href="./dashboard.php" class="btn btn-secondary">Back</a>
            </div>
        </div>
            <div class="modal fade" id="modalNews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalTitle">Update News Data</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="newsForm">
                                <div class="form-outline form-dark mb-4">
                                <input type="hidden" name="newsId" id="newsId" value="">
                                    <label class="form-label" for="titleNews">Title</label>
                                    <input type="text" name="titleNews" id="titleNews" class="form-control form-control" />
                                    <small class="text-danger ml-5" id="nameError"></small>
                                </div>
                                <div class="form-outline form-dark mb-4">
                                    <label class="form-label" for="newsContent">Content</label>
                                    <input type="text" name="newsContent" id="newsContent" class="form-control form-control" />
                                    <small class="text-danger ml-5" id="emailError"></small>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-dark px-5" id="saveNews">Save</button>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <script>
    $(document).ready(function () {
        const getNewsData = () => {
            const url = "../backend/news_data.php";
            let content = "";
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function (news_data) {
                    content = ""; 
                    for (let x in news_data) {
                        content += "<tr>";
                        content += "<td>" + news_data[x]["id"] + "</td>";
                        content += "<td>" + news_data[x]["title"] + "</td>";
                        content += "<td><img src='" + news_data[x]["image"] + "' alt='" + news_data[x]["title"] + "' style='max-width: 100px; max-height: 100px;'></td>";
                        content += "<td>" + news_data[x]["content"] + "</td>";
                        content += "<td>";
                        content += "<button class='btn btn-warning editButton' data-id='" + news_data[x]["id"] + "' data-bs-toggle='modal' data-bs-target='#modalNews'>Edit</button>&nbsp;";
                        content += "<button class='btn btn-danger deleteButton' data-id='" + news_data[x]["id"] + "'>Delete</button>";
                        content += "</td>";
                        content += "</tr>";
                    }
                    $("#contentNews").html(content);
                },
            });
        };

        const clearFormFields = () => {
            $("#titleNews").val("");
            $("#newsContent").val("");
        };

        $(document).on("click", ".editButton", function () {
            const id = $(this).data("id");
            console.log("Edit ID:", id);
            $("#newsId").val(id);

            const data = {
                action: "getById",
                id: id,
            };

            $.ajax({
                type: "POST",
                url: "../backend/news_data.php",
                data: data,
                dataType: "json",
                success: function (news_data) {

                    console.log("Retrieved News Data:", news_data);

                    if (news_data.hasOwnProperty("id") && news_data.hasOwnProperty("title") && news_data.hasOwnProperty("content")) {
                        // Populate form fields with existing data
                        $("#titleNews").val(news_data.title);
                        $("#newsContent").val(news_data.content);
                    } else {
                        console.log("News data not found for ID: " + id);
                    }
                },
                error: function (error) {
                    console.log(error);
                },
            });
        });

        $(document).on("click", "#saveNews", function () {
        const id = $("#newsId").val();
        const title = $("#titleNews").val();
        const content = $("#newsContent").val();

        const data = {
            action: "update",
            id: id,
            title: title,
            content: content,
        };

        $.ajax({
            type: "POST",
            url: "../backend/news_data.php",
            data: data,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status === "OK") {
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: "success",
                    });
                    getNewsData();
                    clearFormFields();
                    $("#modalNews").modal("hide");
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
                title: "Are you sure you want to delete this news?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../backend/news_data.php",
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
                                getNewsData();
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

        getNewsData();
    });
</script>

</body>

</html>
