$(document).ready(function () {
    const getUsersData = () => {
        const url = "../backend/users_data.php";
        let content = "";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (users_data) {
                content = ""; // Clear content variable
                for (let x in users_data) {
            content += "<tr>";
            content += "<td>" + users_data[x]["id"] + "</td>";
            content += "<td>" + users_data[x]["name"] + "</td>";
            content += "<td>" + users_data[x]["username"] + "</td>";
            content += "<td>" + users_data[x]["email"] + "</td>";
            content += "<td>" + users_data[x]["clearance"] + "</td>";
            content += "<td>";
            content +=
              "<button class='btn btn-warning' data-id='" +
              users_data[x]["id"] +
              "' id='editModal'>Edit</button>&nbsp";
            content += "</td>";
            content += "</tr>";
          }
          $("#content").html(content);
        },
      });
    };
  
    const clearFormFields = () => {
        $("#name").val("");
        $("#username").val("");
        $("#email").val("");
      };
    
      $("#userForm").on("submit", function (e) {
        e.preventDefault();
    
        const name = $("#name").val();
        const username = $("#username").val();
        const email = $("#email").val();
        const clearance = $("#clearance").val();
    
        const data = {
          name: name,
          username: username,
          email: email,
          clearance: clearance,
        };
        $.ajax({
          type: "POST",
          url: "../backend/users_data.php",
          data: data,
          dataType: "json",
          success: function (response) {
            console.log(response);
            getUsersData(); 
            clearFormFields(); 
            $("#modalUsers").modal("hide"); 
          },
          error: function (error) {
            console.log(error);
          },
        });
      });
  


      $('#saveUser').on('click', function (e) {
        e.preventDefault();
    
        let formData = new FormData($('#userForm')[0]);
    
        let formUser = $('#userForm');
    
        const url = '../backend/users_data.php';
        const id = $(this).data("id");
        formData.append("action", "update"); 
        formData.append("id", id);
    
        $(this).attr('disabled', true);
    
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "json",
            contentType: false, 
            processData: false, 
            success: function (users_data) {
                $('#saveUser').attr('disabled', false);
    
                if (users_data.error == true) {
                    formUser.find('small').text('');
                    for (let key in users_data) {
                        const errorContainer = formUser.find(`#${key}Error`);
                        if (errorContainer.length !== 0) {
                            errorContainer.html(users_data[key]);
                        }
                    }
                } else if (users_data.status == 'OK') {
                    formUser.trigger('reset');
                    formUser.find('small').text('');
    
                    Swal.fire({
                        icon: 'success',
                        title: users_data.title,
                        text: users_data.msg,
                    }).then(() => {
                        $("#modalUsers").modal("hide");
                    });
                } else if (users_data.status == "error") {
                    Swal.fire({
                        icon: 'error',
                        title: users_data.title,
                        text: users_data.msg,
                    });
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
    getUsersData()
    $(document).on('click', "#editModal", function() {
        $('#modalTitle').text('Edit Users');
        $('#saveUser').text('Save');
        const id = $(this).data("id");
        $("#modalUsers").modal("show");
    
        $.ajax({
            type: "GET",
            url: "../backend/users_data.php",
            data: {
                "id": id,
                "action": "get"
            },
            dataType: "json",
            success: function(users_data) {
                // Populate form fields with existing data
                $('#name').val(users_data.name);
                $('#username').val(users_data.username);
                $('#email').val(users_data.email);
                $('#clearance').val(users_data.clearance);
                $('#saveUser').data('id', id); 
            }
        });
    });
        $(document).on('click', "#deleteProduct", function() {
            const id = $(this).data("id")
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = "../backend/users_data.php";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            "id": id,
                            "action": "delete"
                        },
                        dataType: "JSON",
                        success: function(users_data) {
                            if (users_data.status == 'OK') {
                                Swal.fire({
                                    icon: 'success',
                                    title: users_data.title,
                                    text: users_data.msg,
                                }).then(() => {
                                    getUsersData();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: users_data.title,
                                    text: users_data.msg,
                                }).then(() => {
                                    getUsersData();
                                })
                            }
                        }
                    });
                }
            })
        });   

        //Preview Function
        $(document).ready(function() {
          function previewImage(input) {
            if (input.files && input.files[0]) {
              const reader = new FileReader();
        
              reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
              };
        
              reader.readAsDataURL(input.files[0]);
            }
          }
        
          $('#pict').on('change', function() {
            previewImage(this);
          });
        
          $("#previewModal").on("show.bs.modal", function() {
            const title = $("#title").val();
            const content = $("#news").val();
            const formattedContent = content.replace(/\n/g, '<br>');
        
            $("#previewTitle").text(title);
            $("#previewContent").html(formattedContent);
          });
        });
}); 

//News Handling
$(document).ready(function() {
    $('#submitNews').on('click', function(e) {
      e.preventDefault();
      var form = new FormData($('#uploadNews')[0]);
      console.log(form);
  
      $.ajax({
        url: '../functions/uploadAdmin.php',
        type: 'POST',
        data: form,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.message == 'Content Uploaded Successfully.') {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'News Content Uploaded Successfully!',
            }).then();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong with the upload..',
            });
          }
        },
      });
    });
  });

    //Gallery Handling
    $(document).ready(function() {
        $(document).on('submit', '#uploadGallery', function(e) {
            e.preventDefault();
            var form = new FormData($(this)[0]);
    
            $.ajax({
                url: '../functions/galleryHandling.php',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response || response.message || response.message.includes("Content Uploaded Successfully.")) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: "Successfully Added",
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong with the upload..',
                        });
                    }
                }
            });
        });
    });

function fetchGalleryData() {
  fetch('galleryDatabase.php')
      .then(response => response.json())
      .then(data => {
          // Clear existing gallery content
          document.getElementById('gallery').innerHTML = '';

          // Loop through the gallery data and create HTML elements
          data.forEach(item => {
              // Create a div element for each gallery item
              const div = document.createElement('div');
              div.className = 'gallery-item';
              div.innerHTML = `
                  <img src="${item.img}" alt="${item.title}">
                  <h3>${item.title}</h3>
                  <button onclick="editGalleryItem(${item.id})">Edit</button>
                  <button onclick="deleteGalleryItem(${item.id})">Delete</button>
              `;

              // Append the div to the gallery container
              document.getElementById('gallery').appendChild(div);
          });
      })
      .catch(error => console.error(error));
}

// Function to handle edit gallery item
function editGalleryItem(id) {
  // Redirect to the edit page with the specified ID
  window.location.href = `edit.php?id=${id}`;
}

// Function to handle delete gallery item
function deleteGalleryItem(id) {
  if (confirm('Are you sure you want to delete this item?')) {
      // Send a DELETE request to the PHP backend to delete the item
      fetch(`gallery.php?action=delete&id=${id}`, {
          method: 'DELETE'
      })
      .then(() => {
          // Item deleted successfully, fetch and display updated gallery data
          fetchGalleryData();
      })
      .catch(error => console.error(error));
  }
}
