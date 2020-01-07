$(function ()
{
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass   : 'iradio_square-blue',
    increaseArea : '20%' // optional
  });

  // Jquery Select2
  $(function () {
    $('.select2').select2();
  });

  // Jquery Nice Select
  $(function () {
      $('.nice-select').niceSelect();
  });

  //Colorpicker
  $('.product-colorpicker').colorpicker();

});

$("#users, #products, #subcategories").DataTable();

$('#avatar, #subcategory_thumb, #logo_thumb').change(function readURL()
  {
    if (this.files && this.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#selectedImage')
          .attr('src', e.target.result)
          .width(100)
          .height(120);
      };

      reader.readAsDataURL(this.files[0]);
    }
});




