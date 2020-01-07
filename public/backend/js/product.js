
$(function(){

  var category = $('#category').val();
  embedSubcategory(category);
  tinymce.init({ 
    selector:'#description',
    init_instance_callback: function (editor) {
      editor.on('blur', function (e) {
        var content = editor.getContent();
        var input_field = $("form textarea#description");
        input_field.val(content);
        validate_input(input_field);
      });
    },
    plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount'
    ],
    toolbar: 'formatselect  |  undo redo  |  insert  |  bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'
    ]
  });
});

$(function(){

  if($('#content').length) {

    tinymce.init({ 
      selector:'#content',
      plugins: "autoresize",
      min_height: 450,
      plugins: [
          'advlist autolink lists link image charmap print preview anchor textcolor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table contextmenu paste code help wordcount'
      ],
      toolbar: 'formatselect  |  undo redo  |  insert  |  bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
      content_css: [
          '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
          '//www.tinymce.com/css/codepen.min.css'
      ]
    });
  }

});

$('#category').change(function(){
  var category = $(this).val();
  embedSubcategory(category);
});

function embedSubcategory(category)
{
  var url = "http://www.logicbag.com.bd/backend/category/"+category+"/subcategories";
  $.ajax({
    type: "GET",
    url: url,
    success: function(subcategories){
      $('#subcategory').html("");
      var  selected = 'selected';
      $.each(subcategories, function(id, title){
        $('#subcategory').append(
          "<option value='"+id+"' "+selected+">"+title+"</option>"
        );
        selected = '';
      });
    }
  });
}

const images = [];
Dropzone.autoDiscover = false;
$('#dropZone').dropzone({
    autoProcessQueue: false,
    paramName: "files",
    addRemoveLinks: true,
    maxFilesize: 10, // MB
    maxFiles: 12,
    uploadMultiple: true,
    parallelUploads: 10,
    url: "http://www.logicbag.com.bd/backend/product/pictures/upload",

  init: function() {
    var formId = $('#dropZone').parents('form').attr('id');
    var modelField = $("#"+formId+" input[name=model]");
    var skuField = $("#"+formId+" input[name=sku]");
    var myDropzone = this;
    var startUpload = $(".start-upload");

    startUpload.click(function(e){
      e.preventDefault();
      e.stopPropagation();
      myDropzone.processQueue();
    });

    myDropzone.on('addedfile', function(file) {
      token = $('#'+formId+' input[name=_token]').val();
      var model = modelField.val();
      var sku = skuField.val();
          
      if (model == "" || sku == "") {
        if (model == "") {
          $("form input[name=model], .dropzone").addClass('is-invalid');
          var msg = '<strong>Product "Model" is required before uploading pictures!</strong>';
          $("form input[name=model], .dropzone").next('.invalid-feedback').html(msg);
        }
        if (sku == "") {
          $("form input[name=sku], .dropzone").addClass('is-invalid');
          var msg = '<strong>Product "SKU" is required before uploading pictures!</strong>';
          $("form input[name=sku], .dropzone").next('.invalid-feedback').html(msg);
        }
      } else {
        if ($('#'+formId).find('input[name=id]')) {
          var id = $('#'+formId).find('input[name=id]').val();
          validate_input(modelField, id);
          validate_input(skuField, id);
        } else {
          validate_input(modelField);
          validate_input(skuField);
        }
        $("form input[name=sku], .dropzone").removeClass("is-invalid");
        $("form input[name=sku], .dropzone").addClass('is-valid');
        $("form input[name=sku], .dropzone").siblings('.invalid-feedback').html("");
      }
    });

    myDropzone.on('sendingmultiple', function(file, xhr, formData) {
      model = modelField.val();
      sku = skuField.val();
      formData.append('_token', token);
      formData.append('model', model);
      formData.append('sku', sku);
    });

    myDropzone.on('successmultiple', function(file, response) {
      for (var i = 0; i < response.length; i++) {
        images.push(response[i]);
      }
      $("input[name^=images]").val(images);

      if ($('#dropZone').is('.is-invalid')) {
        $(".dropzone").toggleClass("is-invalid is-valid");
      }
      // var formID = modelField.parents('form').attr('id');
      // submitForm(formID);
    });

    myDropzone.on('errormultiple', function(file, response) {
        console.log(response);
    });

    myDropzone.on("removedfile", function(file) {
      var model = modelField.val();
      var sku = skuField.val();
      if (!(model == "" || sku == "")) {
        var name = file.name;
        $.ajax({
          url: "http://www.logicbag.com.bd/backend/product/picture/delete",
          type: "POST",
          data: { 
            'sku': sku,
            'model': model,
            '_token': token,
            'name': name,
          },
          success: function(response){
            images.splice( $.inArray(name, images), 1);
            $("input[name^=images]").val(images);
            if (images.length == 0) {
              $(".dropzone").addClass('is-invalid');
              var msg = '<strong>Product picture is required!</strong>';
              $(".dropzone").next('.invalid-feedback').html(msg);
            }
          },
          error: function(response){
            console.log(response);
          }
        });
      }
    });
  }
        
});

function showFloatModal(url) {
  var modal = $('#float-modal');
  $.ajax({
      type: "GET",
      url: url,
      datType: 'html',
      success: function(responseView){

          // Remove preloader
          // $('.quick-view-gallery').removeClass('pd-loaded');
          // $('.quick-view-gallery').imagesLoaded( function() {
          //     setTimeout(function(){
          //         $('.quick-view-gallery').addClass('pd-loaded');
          //     }, 1000);
          // });

          // Populate Quick modal
          $("#float-modal").empty().html(responseView);

          // show modal
          modal.modal('show');
          editDragNDrop();
      }
  });
}

$('.edit_attribute').click(function(e){
  e.preventDefault();
  var url = $(this).attr('href');
  showFloatModal(url);
});

function editDragNDrop() {
  $('#editAttributeDropZone').dropzone({
    autoProcessQueue: false,
    paramName: "files",
    addRemoveLinks: true,
    maxFilesize: 10, // MB
    maxFiles: 12,
    uploadMultiple: true,
    parallelUploads: 10,
    thumbnailWidth:250,
    thumbnailHeight:250,
    callCount: 1,
    url: "http://www.logicbag.com.bd/backend/product/pictures/upload",

    init: function() {
      var myDropzone = this;
      var form = $("#edit_attribute_form");
      var skuField = form.find("[name=sku]");
      var modelField = form.find("[name=model]");
      var startUpload = $(".start-upload");

      startUpload.click(function(e){
        e.preventDefault();
        e.stopPropagation();
        myDropzone.processQueue();
      });

      token = $('form input[name=_token]').val();
      model = modelField.val();
      sku = skuField.val();
      images.length = 0;
      myDropzone.removeAllFiles(true);
      $.get('http://www.logicbag.com.bd/backend/attribute/images/'+model+'/'+sku, function(data) {
          $.each(data, function (key, file) {
              var fileObj = {name: file.name, size: file.size};
              myDropzone.options.addedfile.call(myDropzone, fileObj);
              myDropzone.options.thumbnail.call(myDropzone, fileObj, file.location);
              myDropzone.emit("complete", fileObj);
              images.push(fileObj.name);
          });
          myDropzone.options.maxFiles = myDropzone.options.maxFiles - data.length;
          $("input[name^=images]").val(images);
      });

      myDropzone.on('addedfile', function(files) {
        $(".dropzone").removeClass("is-invalid");
        $(".dropzone").addClass('is-valid');
        $(".dropzone").siblings('.invalid-feedback').html("");
      });

      myDropzone.on('sendingmultiple', function(file, xhr, formData) {
        formData.append('_token', token);
        formData.append('model', model);
        formData.append('sku', sku);
      });

      myDropzone.on('successmultiple', function(file, response) {
        for (var i = 0; i < response.length; i++) {
          images.push(response[i]);
        }
        $("input[name^=images]").val(images);
      });

      myDropzone.on('errormultiple', function(file, response) {
        console.log(response);
      });

      myDropzone.on("removedfile", function(file) {
        if (!(model == "" || sku == "")) {
          var name = file.name;
          $.ajax({
            url: "http://www.logicbag.com.bd/backend/product/picture/delete",
            type: "POST",
            data: { 
              'sku': sku,
              'model': model,
              '_token': token,
              'name': name,
            },
            success: function(response){
              images.splice( $.inArray(name, images), 1);
              $("input[name^=images]").val(images);
            },
            error: function(response){
              console.log(response);
            }
          });
        }
      });
    }
  });
}

editDragNDrop();

function validate_input(input_field, id) {
  var formId = input_field.parents('form').attr('id');
  var form = $('#'+formId);
  var _token = $("form input[name=_token]").val();
  var name = input_field.attr("name");
  var value = input_field.val();
  var formData = {
    '_token' : _token, 
    [name] : value,
    'id': id
  }
  return $.ajax({
    url: "http://www.logicbag.com.bd/backend/product/input/validate",
    type: "POST",
    dataType: 'json', 
    data: formData,
    success: function(response){
        // return response;
    },
    error: function (xhr) {
      if (xhr.status == 422) {
        var errors_obj = JSON.parse(xhr.responseText);
        var errors = errors_obj.errors;
        if (name in errors) {
          if (form.find("[name="+name+"]").is('.is-valid')) {
            form.find("[name="+name+"]").removeClass("is-valid");
          }

          if (name == 'category_id' || name == 'subcategory_id' || name == 'tags') {
            form.find("[name="+name+"]").siblings('.select2.select2-container').addClass("is-invalid");
            form.find("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
            form.find("[name="+name+"]").siblings('.select2.select2-container').css({
              "border" : "1px solid red", 
              "border-radius" : "5px"
            });
          } else if (name == 'description') {
            form.find("[name="+name+"]").addClass("is-invalid");
            form.find("[name="+name+"]").siblings('tox-tinymce').css("border-color", "red");
            form.find("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
          } else {
            form.find("[name="+name+"]").addClass("is-invalid");
            form.find("[name="+name+"]").siblings('.invalid-feedback').html(errors[name]);
          }

          return;

        } else {
          if (name == 'model' || name == 'sku') {
            if ($('#dropZone').is('.is-invalid')) {
              if (name == 'model') {
                $("form input[name=model], .dropzone").removeClass("is-invalid");
                $("form input[name=model], .dropzone").addClass('is-valid');
                $("form input[name=model], .dropzone").siblings('.invalid-feedback').html("");
              } else {
                $("form input[name=sku], .dropzone").removeClass("is-invalid");
                $("form input[name=sku], .dropzone").addClass('is-valid');
                $("form input[name=sku], .dropzone").siblings('.invalid-feedback').html("");
              }
            } else {
              form.find("[name="+name+"]").removeClass("is-invalid");
              form.find("[name="+name+"]").siblings('.invalid-feedback').html("");
              form.find("[name="+name+"]").addClass("is-valid");
            }
          } else if (name == 'category_id' || name == 'subcategory_id' || name == 'tags') {
            form.find("[name="+name+"]").siblings('.select2.select2-container').removeClass("is-invalid");
            form.find("[name="+name+"]").siblings('.invalid-feedback').html("");
            form.find("[name="+name+"]").siblings('.select2.select2-container').css({
              "border" : "1px solid green", 
              "border-radius" : "5px"
            });
          } else if (name == 'description') {
            form.find("[name="+name+"]").removeClass("is-invalid");
            form.find("[name="+name+"]").siblings('tox-tinymce').css("border-color", "green");
            form.find("[name="+name+"]").siblings('.invalid-feedback').html("");
            form.find("[name="+name+"]").addClass("is-valid");
          } else {
            form.find("[name="+name+"]").removeClass("is-invalid");
            form.find("[name="+name+"]").siblings('.invalid-feedback').html("");
            form.find("[name="+name+"]").addClass("is-valid");
          } 
        }
      }
    }
  });
}  

function submitForm(formId){
  if (!(images.length > 0)) {
    $(".dropzone").addClass("is-invalid");
    var msg = '<strong>Product pictures are required!</strong>';
    $(".dropzone").siblings('.invalid-feedback').html(msg);
  } else {
    $("input[name^=images]").val(images);
    var form = $('#'+formId),
        formData = form.serialize(),
        url = form.attr('action'),
        method = form.attr('method');
    $.ajax({
      url: url,
      type: method,
      dataType: 'json', 
      data: formData,
      success: function(response){
          successReply(response);
      },
      error: function (xhr) {
        console.log(xhr);
          errorProcess(xhr, formId);
      }
    });
  }
}

function successReply(response){
  swal('Success', response['status'], 'success', {
    buttons: [
        false, true
    ]
  })
    .then((value) => {
      window.location.reload(true);
      // window.location.replace("http://www.logicbag.com.bd/backend/products");
    });
}

function errorProcess(xhr, formId){
  var form = $('#'+formId);
  if (xhr.status == 422) {
    var errors_obj = JSON.parse(xhr.responseText);
    var errors = errors_obj.errors;
    for (name in errors) {
      if (name == 'category_id' || name == 'subcategory_id' || name == 'tags') {
        form.find("[name="+name+"]").siblings('.select2.select2-container').addClass("is-invalid");
        form.find("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
        form.find("[name="+name+"]").siblings('.select2.select2-container').css({
          "border" : "1px solid red", 
          "border-radius" : "5px"
        });
      } else if (name == 'description') {
          $("[name="+name+"]").siblings('#mceu_17').addClass("is-invalid");
        $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
      } else if(name == 'images'){
        $(".dropzone").addClass("is-invalid");
        $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
      } else {
        $("[name="+name+"]").addClass("is-invalid");
        $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
      }
    }
  } else {
      if (xhr['warning']) {
      $(".alert-danger").html(xhr['warning']);
      $(".alert-danger").removeClass("d-none");
    }
  }
}

$('#edit_product_form').submit(function(e){
  e.preventDefault();
  var formData = $(this).serialize();
  var url = $(this).attr('action');
  $.ajax({
    url: url,
    type: "POST",
    dataType: 'json', 
    data: formData,
    success: function(response){
      successReply(response);
    },
    error: function (xhr) {
      errorProcess(xhr);
    }
  });
});

$(document).ready(function() {

  // Product archive confirmation
  $(".delete, .destroy").each(function() {
    $(this).click(function(e) {
      e.preventDefault();
      var url = $(this).attr('href');
      var title = $(this).attr('title');
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        animation: false,
        // imageUrl: 'https://www.unsplash.it/400/200',
        // imageWidth: 400,
        // imageHeight: 200,
        // imageAlt: 'Custom image',
        customClass: 'animated tada',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, I understand!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: url,
            type: "GET",
            success: function(response){
              swal({
                type: 'success',
                title: 'Deleted',
                text: response.status
              }).then((result) => {
                window.location.reload(true);
              })
            },
            error: function(response){
              swal({
                type: 'error',
                title: response.status,
                text: response.responseJSON.message,
                footer: '<a href="'+response.getResponseHeader('url')+'">Why do I have this issue?</a>'
              })
            }
          });
        }
      });
    });
  });

  // Product form validate input fields
  $("#product_form [name]").each(function() {
    var name = $(this).attr("name");
    var input_field = $(this);
    if (name == "category_id" || name == "subcategory_id" || name == "tags") {
      $(this).on('change', function(){
        validate_input(input_field);
      });
    } else {
      $(this).on('keyup', function(){
        validate_input(input_field);
      });

      $(this).on('focusout', function(){
        validate_input(input_field);
      });
    }
  });

  $("#edit_product_form [name]").each(function() {
    var name = $(this).attr("name");
    var productId = $("#edit_product_form [name=id]").val();
    var input_field = $(this);
    if (name == "category_id" || name == "subcategory_id" || name == "tags") {
      $(this).on('change', function(){
        validate_input(input_field, productId);
      });
    } else {
      $(this).on('keyup', function(){
        validate_input(input_field, productId);
      });

      $(this).on('focusout', function(){
        validate_input(input_field, productId);
      });
    }
  });

  // Attribute edit functions
  $("#attribute_form [name]").each(function() {
    var name = $(this).attr("name");
    var input_field = $(this);
    $(this).on('keyup', function(){
      validate_input(input_field);
    });

    $(this).on('focusout', function(){
      validate_input(input_field);
    });
  });

  // Attribute edit functions
  $("body").on('keyup', '#edit_attribute_form [name]', function() {
    var input_field = $(this);
    var attributeId = $("#edit_attribute_form [name=id]").val();
    validate_input(input_field, attributeId);
  });

  $("body").on('focusout', '#edit_attribute_form [name]', function() {
    var input_field = $(this);
    var attributeId = $("#edit_attribute_form [name=id]").val();
    validate_input(input_field, attributeId);
  });

  $("form#product_form #submit, form#edit_product_form #submit, form#attribute_form #submit, form#edit_attribute_form #submit").click(function(e){
    e.preventDefault();
    var formID = $(this).parents('form').attr('id');
    submitForm(formID);
  });

});



