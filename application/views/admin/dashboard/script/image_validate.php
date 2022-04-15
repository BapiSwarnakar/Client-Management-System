<script type="text/javascript">
///////////////////////// IMAGE CHECK ///////////////////////////////////////
// Check Valid Image
  $(document).ready(function(){
//  MADHYAMIK DOC UPLOAD
     //$('#success').hide();

    $("#file").change(function () {

        if(fileExtValidate(this)) {
           if(fileSizeValidate(this)) {
            showImg(this);
           }   
        }    
      });
    // File extension validation, Add more extension you want to allow
    var validExt = ".jpg , .jpeg , .png";
    function fileExtValidate(fdata) {
     var filePath = fdata.value;
     var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
     var pos = validExt.indexOf(getFileExt);
     if(pos < 0) {
       toastr.options = {
                  "closeButton": true,  // true or false
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,  // true or false
                  "rtl": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false, // true or false
                  "showDuration": 300,
                  "hideDuration": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                 }
                  $('#file').val('');
                  toastr["error"]("This file is not allowed, please upload valid file.", "Message");
                  //$('#success').hide();
      //alert("This file is not allowed, please upload valid file.");
                
      return false;
      } else {
        return true;
      }
    }
    // file size validation
    function fileSizeValidate(file) {
        var FileSize = file.files[0].size/1024/1024;  //1024/1024; // in MB
        if (FileSize >20) {  /// 15 MB CHECK ALL FILE
             toastr.options = {
                  "closeButton": true,  // true or false
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,  // true or false
                  "rtl": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false, // true or false
                  "showDuration": 300,
                  "hideDuration": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                 }
                  $('#file').val('');
                  toastr["warning"]("File size exceeds 3 MB"+FileSize, "Message");
            //alert('File size exceeds 1 MB'+FileSize);
              //$('#success').hide();
              
              // $('#zip_img').attr('src','');
          return false;
           // $(file).val(''); //for clearing with Jquery
        } else {
            //alert('File size '+FileSize);
              return true;
          }
       }
     // display img preview before upload.
    function showImg(fdata) {
            if (fdata.files && fdata.files[0])
             {

              var file = fdata.files[0];
              var tmpImg = new Image();
              tmpImg.src=window.URL.createObjectURL( file ); 
              tmpImg.onload = function() {
                width = tmpImg.naturalWidth,
                height = tmpImg.naturalHeight;
               if($('#width').val() !='' && $('#width').val())
               {
                  if(width!=$('#width').val() && height!=$('#width').val())
                {
                   toastr.options = {
                          "closeButton": true,  // true or false
                          "debug": false,
                          "newestOnTop": false,
                          "progressBar": true,  // true or false
                          "rtl": false,
                          "positionClass": "toast-top-right",
                          "preventDuplicates": false, // true or false
                          "showDuration": 300,
                          "hideDuration": 1000,
                          "timeOut": 5000,
                          "extendedTimeOut": 1000,
                          "showEasing": "swing",
                          "hideEasing": "linear",
                          "showMethod": "fadeIn",
                          "hideMethod": "fadeOut"
                         }
                          $('#file').val('');
                          toastr["error"]("This Image Dimension is Wrong !", "Message");
                      return false;
                }
                else
                {
                   toastr.options = {
                  "closeButton": true,  // true or false
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,  // true or false
                  "rtl": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false, // true or false
                  "showDuration": 300,
                  "hideDuration": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                 }
                  toastr["success"]("Image Upload Success", "Message");
                  return true;
                }
               }
               else
               {
                 toastr.options = {
                  "closeButton": true,  // true or false
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,  // true or false
                  "rtl": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false, // true or false
                  "showDuration": 300,
                  "hideDuration": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                 }
                  toastr["success"]("Image Upload Success", "Message");
                  return true;
               }
               
                
              }
              //   var reader = new FileReader();
              // reader.onload = function (e) 
              //   {
              //     toastr.options = {
              //     "closeButton": true,  // true or false
              //     "debug": false,
              //     "newestOnTop": false,
              //     "progressBar": true,  // true or false
              //     "rtl": false,
              //     "positionClass": "toast-top-right",
              //     "preventDuplicates": false, // true or false
              //     "showDuration": 300,
              //     "hideDuration": 1000,
              //     "timeOut": 5000,
              //     "extendedTimeOut": 1000,
              //     "showEasing": "swing",
              //     "hideEasing": "linear",
              //     "showMethod": "fadeIn",
              //     "hideMethod": "fadeOut"
              //    }
              //     toastr["success"]("Image Upload Success", "Message");
              //     // $('#zip_img').attr('src', e.target.result);
              //     //$('#success').show();
              //   }
              //   reader.readAsDataURL(fdata.files[0]);
            }
        }

     });

// .//////////////////////PDF CHECK///////////////////////////////////


// Check Valid Image
  $(document).ready(function(){
//  MADHYAMIK DOC UPLOAD
     //$('#success').hide();

    $("#pdf").change(function () {

        if(fileExtValidate(this)) {
           if(fileSizeValidate(this)) {
            showImg(this);
           }   
        }    
      });
    // File extension validation, Add more extension you want to allow
    var validExt = ".pdf";
    function fileExtValidate(fdata) {
     var filePath = fdata.value;
     var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
     var pos = validExt.indexOf(getFileExt);
     if(pos < 0) {
       toastr.options = {
                  "closeButton": true,  // true or false
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,  // true or false
                  "rtl": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false, // true or false
                  "showDuration": 300,
                  "hideDuration": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                 }
                  $('#pdf').val('');
                  toastr["error"]("This file is not allowed, please upload valid file.", "Message");
                  //$('#success').hide();
      //alert("This file is not allowed, please upload valid file.");
                
      return false;
      } else {
        return true;
      }
    }
    // file size validation
    function fileSizeValidate(file) {
        var FileSize = file.files[0].size/1024/1024;  //1024/1024; // in MB
        if (FileSize >20) {  /// 15 MB CHECK ALL FILE
             toastr.options = {
                  "closeButton": true,  // true or false
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,  // true or false
                  "rtl": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false, // true or false
                  "showDuration": 300,
                  "hideDuration": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                 }
                  $('#pdf').val('');
                  toastr["warning"]("File size exceeds 3 MB"+FileSize, "Message");
            //alert('File size exceeds 1 MB'+FileSize);
              //$('#success').hide();
              
              // $('#zip_img').attr('src','');
          return false;
           // $(file).val(''); //for clearing with Jquery
        } else {
            //alert('File size '+FileSize);
              return true;
          }
       }
     // display img preview before upload.
    function showImg(fdata) {
            if (fdata.files && fdata.files[0])
             {

              var reader = new FileReader();
              reader.onload = function (e) 
                {
                  toastr.options = {
                  "closeButton": true,  // true or false
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,  // true or false
                  "rtl": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false, // true or false
                  "showDuration": 300,
                  "hideDuration": 1000,
                  "timeOut": 5000,
                  "extendedTimeOut": 1000,
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                 }
                  toastr["success"]("Image Upload Success", "Message");
                  // $('#zip_img').attr('src', e.target.result);
                  //$('#success').show();
                }
                reader.readAsDataURL(fdata.files[0]);
            }
        }

     });
</script>
