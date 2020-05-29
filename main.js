// console.log = function() {};
// JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict'

    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation')

        // Loop over them and prevent submission
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated')
            }, false)
        })
    }, false)
}())

var Upload = function(file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
    return this.file.name;
};

Upload.prototype.doUpload = function() {
    var that = this;
    var formData = new FormData();
    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    $.ajax({
        type: "POST",
        url: "api/setProduct.php",
        xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function(data) {
            if (data.uploadResult) {
                product_images.push(data.URL);
            }
        },
        error: function(error) {
            // handle error
            console.log(error);
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

Upload.prototype.progressHandling = function(event) {
    var percent = 0;
    var position = event.loaded || event.position;
    var total = event.total;
    var progress_bar_id = "#progress-wrp";
    if (event.lengthComputable) {
        percent = Math.ceil(position / total * 100);
    }
    // update progressbars classes so it fits your code
    $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
    $(progress_bar_id + " .status").text(percent + "%");
};

$(document).ready(function() {
    product_images = [];
    $("#alert_success").hide();
    $("#alert_error").hide();
    // $("#file-info").hide();
    $("#file-error").hide();
    $("#product_color").change(function() {
        product_color = $(this).children("option:selected").val();
    });

    // process the form
    $('#addProductForm').submit(function(event) {
        product_avail = "Out Of Stock";
        if ($("#in-stock").is(":checked"))
            product_avail = "In Stock";
        $.ajax({
            type: "POST",
            url: "api/setProduct.php",
            data: {
                "product_price": $('input[name=product_price]').val(),
                "product_desc": $('input[name=product_desc]').val(),
                "product_avail": product_avail,
                "product_color": product_color,
                "product_images": product_images,
            },
            success: function(data) {
                $("#alert_success").text("Product Added: " + data.productId);
                $("#alert_success").show();
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation')

                // Loop over them and prevent submission
                Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        // if (form.checkValidity() === false) {
                        //     event.preventDefault();
                        //     event.stopPropagation();
                        // }
                        form.classList.remove('was-validated')
                    }, false)
                })
                console.log(data);
            },
            error: function(error) {
                $("#alert_error").show();
                // handle error
                console.log(error.responseText);
            },

        });
        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });
});
currentUploadedFiles = 0;
// image uploader
$("#product_image").on("change", function(e) {
    if (currentUploadedFiles > 2) {
        $("#file-error").text("Remove one or more files to add more!");
        $("#file-error").show();
        setTimeout(function() {
            $("#file-error").hide();
        }, 5000);
    } else {
        numberOfUploadedFiles = $(this)[0].files.length;
        countError = true;
        sizeError = true;
        typeError = true;
        uploadErrors = [];

        //  check number of fikes
        if (numberOfUploadedFiles < 4) {
            countError = false;
            for (i = 0; i < numberOfUploadedFiles; i++) {
                var file = $(this)[0].files[i];
                var upload = new Upload(file);

                //check file type
                const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
                if (validImageTypes.includes(upload.getType())) {
                    typeError = false;
                } else {
                    uploadErrors.push("Invalid file! Please try again with image files.");
                    break;
                }
                //check file size
                if ((upload.getSize() / 1024 / 1024) <= 5) {
                    sizeError = false;
                } else {
                    uploadErrors.push("File too big! Try again with file size up to 5 MB.");
                    break;
                }
            }
        } else {
            uploadErrors.push("Too many files! Please try again with up to 3 files.");
        }
        //  console.log(uploadErrors);
        $("#file-error").text(uploadErrors[0]);
        $("#file-error").show();

        if (uploadErrors.length === 0) {
            $("#file-error").hide();
            for (i = 0; i < numberOfUploadedFiles; i++) {
                var file = $(this)[0].files[i];
                var upload = new Upload(file);
                upload.doUpload();
                currentUploadedFiles = currentUploadedFiles + 1;
                file_list = $("#file-info").html();
                // $("#file-info").text((i + 1) + " of " + (numberOfUploadedFiles) + " uploaded!");
                add_upload_file_to_list = `<div class = "mt-0 pt-0 px-2 my-2 d-flex justify-content-between align-items-center" id = "upload-file-list" >
                <span id = "file-name-` + (i + 1) + `">` + upload.getName() + `</span>
                <div class = "btn btn-outline-danger p-0 px-2 remove" id = "remove-file-` + (i + 1) + `" onclick="removeUploaded(this)"> X </div>
                </div >
            `;
                $("#file-info").html(file_list + add_upload_file_to_list);
                //  var textt = $("#file-info").text();
                //  if (i == numberOfUploadedFiles - 1) {
                //      $("#file-info").text(textt + ", " + upload.getName() + " uploaded!");
                //  } else {
                //      $("#file-info").text(textt + " " + upload.getName());
                //  }
                $("#file-info").show();

            }
        }
    }
});

function removeFromArray(array, element) {
    const index = array.indexOf(element);
    array.splice(index, 1);
}


function removeUploaded(ele) {
    console.log(JSON.stringify(product_images));

    list_item = ele.parentNode;
    theItem = list_item.childNodes;
    for (i = 0; i < product_images.length; i++) {
        indexOfFile = product_images[i].includes($("#" + theItem[1].id).text())
        console.log("Comparing in product_images[" + i + "], finding " + $("#" + theItem[1].id).text() + " Result: " + indexOfFile);
        if (indexOfFile) {
            // removeFromArray(product_images, indexOfFile);
            product_images.splice(indexOfFile, 1);
            currentUploadedFiles = currentUploadedFiles - 1;
        }
        list_item.remove();
    }
}