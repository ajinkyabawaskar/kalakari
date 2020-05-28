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
     formData.append("fileUpload", true);
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
             console.log(data);
             product_images = data.URL;
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
     $("#product_color").change(function() {
         product_color = $(this).children("option:selected").val();
         console.log(product_color);
     });
     // process the form
     $('#addProductForm').submit(function(event) {
         // stop the form from submitting the normal way and refreshing the page
         event.preventDefault();
         $.ajax({
             type: "POST",
             url: "api/setProduct.php",
             data: {
                 "fileUpload": false,
                 "product_price": $('input[name=product_price]').val(),
                 "product_desc": $('input[name=product_desc]').val(),
                 "product_avail": $('input[name=product_avail]').val(),
                 "product_color": product_color,
                 "product_images": product_images,
             },
             success: function(data) {
                 console.log(data);
             },
             error: function(error) {
                 // handle error
                 console.log(error.responseText);
             },

         });

     });
 });

 //Change id to your id
 $("#product_image").on("change", function(e) {
     var file = $(this)[0].files[0];
     var upload = new Upload(file);

     // maby check size or type here with upload.getSize() and upload.getType()

     // execute upload
     upload.doUpload();
 });