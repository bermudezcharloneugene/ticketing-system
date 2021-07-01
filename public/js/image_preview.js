function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#img-preview').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }else {
        $('#img-preview').attr('src', 'https://via.placeholder.com/150');
    }
}
  
    $("#avatar").on('change',function() {
        readURL(this);
    });

    $('.custom-file-input').on('change', function() { 
        let fileName = $(this).val().split('\\').pop(); 
        $(this).next('.custom-file-label').addClass("selected").html(fileName); 
     });