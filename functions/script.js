//Login 
function submitData(){
    $(document).ready(function(){
        var form = {
            name: $('#name').val(),
            email: $('#email').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            passwordRepeat: $('#passwordRepeat').val(),
            action: $('#action').val(),
        };
        $('#formlogin').on('submit',function(e){
            e.preventDefault();
        })

        $.ajax({
            url: '../functions/function.php',
            type: 'POST',
            data: form,
            success:function(response){
                if(response == 'Login Successful'){
                    $('#staticBackdropSuccess').modal('toggle');
                    document.getElementById("loginResponse").innerHTML = response;
                    
                }
                else{
                    $('#staticBackdrop').modal('toggle');
                    document.getElementById("alert").innerHTML = response;
                }
            }
        })
    });
}
//Upload Blog
$(document).ready(function() {
    $('#submitUserData').on('click', function(e) {
        e.preventDefault();
        var form = new FormData($('#upload')[0]);
        console.log(form);

        $.ajax({
            url: '../functions/upload.php',
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.message == 'Content Uploaded Successfully.') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Your Blog Is Successfully Upated!',
                      })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong with the update..',
                      })
                }
            }
        });
    });
});
//No Scroll
$(document).ready(function() {
    $('a[href^="#"]').on('click', function(event) {
        event.preventDefault();

        var target = $($(this).attr('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 500);
        }
    });
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
  
    $('#file').on('change', function() {
      previewImage(this);
    });
  
    $('#previewModal').on('show.bs.modal', function() {
      const content = $('#content').val();
      const formattedContent = content.replace(/\n/g, '<br>'); // Replace newlines with <br>
      const imageSrc = $('#previewImage').attr('src');
  
      $('#previewContent').get(0).innerHTML = formattedContent; // Set innerHTML with line breaks
      $('#previewImage').attr('src', imageSrc);
    });
  });

//Read and Blog Update
$(document).ready(function() {
    const getBlogData = () => {
        const url = "../backend/blog_data.php";
        let contentBlog = "";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(blog_data) {
                contentBlog = ""; // Clear content variable
                for (let x in blog_data) {
                    const content = blog_data[x]["content"];
                    const trimmedContent = content.split(' ').slice(0, 100).join(' ');
                    contentBlog += "<tr>";
                    contentBlog += "<td><img src='" + blog_data[x]["image"] + "' alt='Image' style='width: 40em; height: 20em; border: 1px solid black; border-radius: 5px;'></td>";
                    contentBlog += "<td>" + trimmedContent + ".." + "</td>";
                    contentBlog += "<td>";
                    contentBlog +=
                        "<button class='btn btn-warning editBlog' data-id='" +
                        blog_data[x]["id"] +
                        "'>Edit</button>&nbsp";
                    contentBlog +=
                        "<button class='btn btn-danger deleteBlog' data-id='" +
                        blog_data[x]["id"] +
                        "'>Delete</button>";
                    contentBlog += "</td>";
                    contentBlog += "</tr>";
                }
                $("#contentBlog").html(contentBlog);
            },
        });
    };
    const clearFormFields = () => {
        $("#content").val("");
    };

    $("#blogForm").on("submit", function(e) {
        e.preventDefault();
        const form = new FormData();
        form.append('content', content);
        form.append('action', 'update');
        
        $.ajax({
            type: "POST",
            url: "../backend/blog_data.php",
            data: form,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(response) {
                console.log(response);
                getBlogData();
                clearFormFields();
                $("#editBlog").modal("hide");
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $(document).on('click', ".editBlog", function() {
        $('#modalTitle').text('Edit Blog');
        $('#updateBlog').text('Save');
        const id = $(this).data("id");
        $("#editBlog").modal("show");
    
        $.ajax({
            type: "GET",
            url: "../backend/blog_data.php",
            data: {
                "id": id,
                "action": "get"
            },
            dataType: "json",
            success: function(blog_data) {
                const blogEntry = blog_data.find(entry => entry.id === id); // Find the matching blog entry based on id
                if (blogEntry) {
                    // Populate form fields with existing data
                    $('#content').val(blogEntry.content);
                    $('#updateBlog').data('id', id);
                }
            }
        });
    });
    

    $(document).on('click', ".deleteBlog", function() {
        const id = $(this).data("id");
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
                const url = "../backend/blog_data.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        "id": id,
                        "action": "delete"
                    },
                    dataType: "JSON",
                    success: function(blog_data) {
                        if (blog_data.status == 'OK') {
                            Swal.fire({
                                icon: 'success',
                                title: blog_data.title,
                                text: blog_data.msg,
                            }).then(() => {
                                getBlogData();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: blog_data.title,
                                text: blog_data.msg,
                            }).then(() => {
                                getBlogData();
                            });
                        }
                    }
                });
            }
        });
    });
    const truncateText = (text, limit) => {
        const words = text.split(" ");
        if (words.length > limit) {
            return words.slice(0, limit).join(" ") + "...";
        }
        return text;
    };
    
    const getBlogGlobalData = () => {
        const url = "../backend/global_data.php";
        let contentBlog = "";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (blogs_data) {
                contentBlog = ""; // Clear content variable
                for (let x in blogs_data) {
                    const content = blogs_data[x].content;
                    const truncatedContent = truncateText(content, 50);
                    const fullContent = content;
    
                    contentBlog += `
                        <div class="col">
                            <div class="card" style="width: 18rem;">
                                <img src="${blogs_data[x].image}" class="card-img-top" alt="Image">
                                <div class="card-body">
                                    <p class="card-text truncated-text">${truncatedContent}</p>
                                    <button class="btn btn-primary btn-read-more" data-toggle="modal" data-target="#exampleModal-${x}">Read More</button>
                                </div>
                            </div>
                        </div>
                    `;
    
                    //Modal
                    const modal = `
                        <div class="modal fade" id="exampleModal-${x}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <img src="${blogs_data[x].image}" class="card-img-top" alt="Image">
                                    <div class="modal-body">
                                        ${fullContent}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $("body").append(modal);
                }
                $("#contentBlog").html(contentBlog);
            },
        });
    };
    
    $(document).on("click", ".btn-read-more", function () {
        const target = $(this).data("target");
        $(target).modal("show");
    });

    const runCodeBasedOnURL = () => {
        const currentURL = window.location.href;
      
        // Check if the current URL contains a specific value
        if (currentURL.includes("content.php")) {
          // Run the code for the specific URL
          getBlogData();
        }else{
          // Run the code for other URLs
          getBlogGlobalData();
        }
      };
      runCodeBasedOnURL();
    });


  