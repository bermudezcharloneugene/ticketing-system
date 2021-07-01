<?php include_once '../layouts/protected/header.php'; ?>

    <div class="container mt-5 image-upload-form">
        <div class="mb-3 mt-3 image-preview-wrapper text-center" data-toggle="modal" data-target="#imageUpload">
            <img id="img-prev" class="image-prev" src="" alt="profile image">
        </div>
        <div class="mt-3 mb-3">
            <form action="" class="">
                <div class="form-group text-center">
                    <p class="text-muted"><em><?php if(isset($_SESSION['email'])) {
                echo $_SESSION['email'];
            } ?></em></p>
                </div>
                <div class="form-group text-center">
                    <a href="./changepassword.php">Reset Password</a>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="imageUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="text-center mb-5">
                    <img id="img-preview" class="img-preview" src="" alt="profile image" >
                </div>
                <div class="progress mb-3 d-none">
                    <div id="progress-bar"  class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="1"  aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                <form action="../../app/controls/SettingsController.php" method="POST" id="formHandler">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="avatar" name="avatar" >
                          <label class="custom-file-label" >Choose file</label>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-block" id="submit">Update</button>
                    </div>
                </form>
          </div>
        </div>
      </div>
    </div>
<?php include_once '../layouts/protected/scripts.php'; ?>
    <script>
        //   var loadFile = function(event) {
        //   var output = document.getElementById('img-preview');
        //   console.log(output);
        //   output.src = URL.createObjectURL(event.target.files[0]);
        //   console.log(ouput.src);
        //   output.onload = function() {
        //     URL.revokeObjectURL(output.src) // free memory
        //   }
        // };

        $(document).ready(function() {
            $('#formHandler').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    xhr: function() {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                $(".progress-bar").width(percentComplete + '%');
                                $(".progress-bar").html(percentComplete+'%');
                            }
                        }, false);
                        return xhr;
                    },
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(data) {
                        $('.progress').removeClass('d-none');
                        $(".progress-bar").width('0%');
                        // $('#uploadsuccessfully').html('<img src="images/ajaxloading.gif"/>');
                    },
                    success: function(data) {
                        console.log(data)
                    },
                    error: function(data) {

                    }
                });
            });
        });
    </script>
    <!-- <script type="text/javascript" src="../../public/js/profiles.js"> </script> -->
<?php include_once '../layouts/protected/footer.php'; ?>