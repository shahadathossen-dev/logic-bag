
$(function(){

  var category = $('#category').val();
  embedSubcategory(category);
  tinymce.init({ 
    selector:'#description',
    init_instance_callback: function (editor) {
      editor.on('blur', function (e) {
        var content = editor.getContent();
          var input_field = $("#product_form textarea");
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
        '//www.tinymce.com/css/codepen.min.css']
    });
});

$('#category').change(function(){
  var category = $(this).val();
  embedSubcategory(category);
});

function embedSubcategory(category)
{

  var url = "http://logicbagbd.com/admin/category/"+category+"/subcategories";

    $.ajax({
      type: "GET",
      url: url,
      success: function(subcategories){
        $('#subcategory').html("");
        $.each(subcategories, function(id, title){
          $('#subcategory').append(
                    "<option value='"+id+"'>"+title+"</option>"
            );

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
    url: "http://logicbagbd.com/admin/product/pictures/upload",

  init: function() {
      var myDropzone = this;
      var submit = $("#submit");
      submit.click(function(e){
        e.preventDefault();
          e.stopPropagation();
          myDropzone.processQueue();
      });
    myDropzone.on('addedfile', function(files) {
      model = $("form input[name=model]").val();
      token = $('form input[name=_token]').val();
      sku = $("form input[name=sku]").val();
          
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
        modelField = $("form input[name=model]");
          var skuField = $("form input[name=sku]");
        validate_input(modelField);
        validate_input(skuField);
          }
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
        var formID = modelField.parents('form').attr('id');
        submitForm(formID);
      });

      myDropzone.on('errormultiple', function(file, response) {
          console.log(response);
      });

      myDropzone.on("removedfile", function(file) {
      if (!(model == "" || sku == "")) {
            var name = file.name;
        $.ajax({
            url: "http://logicbagbd.com/admin/product/picture/delete",
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

function dragNDrop(dropZoneId) {
  $('#'+dropZoneId).dropzone({
  // $('#attributeDropZone').dropzone({
      // autoProcessQueue: false,
      paramName: "files",
      addRemoveLinks: true,
      maxFilesize: 10, // MB
      maxFiles: 12,
      uploadMultiple: true,
      parallelUploads: 10,
      thumbnailWidth:250,
      thumbnailHeight:250,
      callCount: 1,
      url: "http://logicbagbd.com/admin/product/pictures/upload",

    init: function() {
      var myDropzone = this;
      var form = $("#edit_attribute_form");
      var skuField = form.find("[name=sku]");
      var modelField = form.find("[name=model]");
      model = modelField.val();
      sku = skuField.val();
      token = $('form input[name=_token]').val();
      images.length = 0;
      // Dropzone.forElement("div#myDrop").removeAllFiles(true);
      myDropzone.removeAllFiles(true);
      $.get('http://logicbagbd.com/admin/attribute/images/'+model+'/'+sku, function(data) {
          $.each(data, function (key, value) {
              var file = {name: value.original, size: value.size};
              myDropzone.options.addedfile.call(myDropzone, file);
              myDropzone.options.thumbnail.call(myDropzone, file, value.server);
              myDropzone.emit("complete", file);
              images.push(file.name);
          });
          myDropzone.options.maxFiles = myDropzone.options.maxFiles - data.length;
          $("input[name^=images]").val(images);
      });

      myDropzone.on('addedfile', function(files) {
          // myDropzone.processQueue();
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
        // var formID = modelField.parents('form').attr('id');
        // submitForm(formID);
      });

      myDropzone.on('errormultiple', function(file, response) {
        console.log(response);
      });

      myDropzone.on("removedfile", function(file) {
        if (!(model == "" || sku == "")) {
          var name = file.name;
          $.ajax({
            url: "http://logicbagbd.com/admin/product/picture/delete",
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

function verifyBforeUpload(myDropzone) {
  
} 

function validate_input(input_field, id) {

    var _token = $("form input[name=_token]").val();
    var name = input_field.attr("name");
    var value = input_field.val();
    var formData = {
      '_token' : _token, 
      [name] : value,
      'id': id
    }
    return $.ajax({
      url: "http://logicbagbd.com/admin/product/input/validate",
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
                  if (name == 'description') {
                      $("[name="+name+"]").addClass("is-invalid");
                      $("[name="+name+"]").siblings('#mceu_17').css("border-color", "red");
                    $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                } else if (name == 'category_id' || name == 'subcategory_id') {
                    $("[name="+name+"]").siblings('.select2.select2-container').addClass("is-invalid");
                    $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                    $("[name="+name+"]").siblings('.select2.select2-container').css({
                      "border" : "1px solid red", 
                      "border-radius" : "5px"
                    });
                } else {
                  $("[name="+name+"]").addClass("is-invalid");
                      $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name]);
                }
                } else {
                  if (name == 'description') {
                      $("[name="+name+"]").removeClass("is-invalid");
                      $("[name="+name+"]").siblings('#mceu_17').css("border-color", "green");
                    $("[name="+name+"]").siblings('.invalid-feedback').html("");
                      $("[name="+name+"]").addClass("is-valid");
                } else if (name == 'category_id' || name == 'subcategory_id' || '') {
                    $("[name="+name+"]").siblings('.select2.select2-container').removeClass("is-invalid");
                    $("[name="+name+"]").siblings('.invalid-feedback').html("");
                    $("[name="+name+"]").siblings('.select2.select2-container').css({
                      "border" : "1px solid green", 
                      "border-radius" : "5px"
                    });
                } else {
                  $("[name="+name+"]").removeClass("is-invalid");
                      $("[name="+name+"]").siblings('.invalid-feedback').html("");
                  $("[name="+name+"]").addClass("is-valid");
                } 
                }
            }
        }
    });
}  

function submitForm(id){

    if (!(images.length > 0)) {
      $(".dropzone").addClass("is-invalid");
      var msg = '<strong>Product pictures are required!</strong>';
      $(".dropzone").siblings('.invalid-feedback').html(msg);
    } else {
        $("input[name^=images]").val(images);
        var form = $('#'+id);
        var formData = form.serialize();
        var url = form.attr('action');
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'json', 
            data: formData,
            success: function(response){
              swal('Success', response['status'], 'success', {
                    buttons: [
                        false, true
                    ]
              })
                .then((value) => {
                  window.location.reload(true);
                  // window.location.replace("http://logicbagbd.com/admin/products");
                });
            },
            error: function (xhr) {
                if (xhr.status == 422) {
                    var errors_obj = JSON.parse(xhr.responseText);
                    var errors = errors_obj.errors;
                    for (name in errors) {
                      if (name == 'category_id' || name == 'subcategory_id' || name == 'tags') {
                          $("[name="+name+"]").siblings('.select2.select2-container').addClass("is-invalid");
                        $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
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
      });
    }
}

$(document).ready(function() {
  //group add limit
  var maxGroup = 10;
  
  //add more fields group
  $(".addMore").click(function() {
    var attributeLength = $('body').find('.attribute-group').length;
      if(attributeLength < maxGroup){
        var newAttribute = $(".attribute-group-copy").find('.dropzone').attr("id", "dropZone"+(attributeLength+1));
          var attributeGroup = '<div class="col-md-6 attribute-group">'+$(".attribute-group-copy").html()+'</div>';
          if (attributeLength > 0) {
            $('body').find('.attribute-group:last').after(attributeGroup);
      fileDragNDrop("dropZone"+(attributeLength+1));
          } else {
            $('body').find('.attribute-field').html(attributeGroup);
      fileDragNDrop("dropZone"+(attributeLength+1));
          }
      }else{
          alert('Maximum '+maxGroup+' attributes are allowed.');
      }
  });
  
  //remove fields group
  $("body").on("click",".remove", function() {

    $.ajax({
    url: "http://logicbagbd.com/admin/product/pictures/delete",
    type: "POST",
    data: { 
      'sku': sku,
      'model': model,
      '_token': token,
    },
      success: function(response){
          images.length = 0;
          $(this).parents('.attribute-group').remove();
      },
      error: function(response){
        console.log(response);
      }
    });
  });

  // Product delte confirmation
  $(".delete").each(function() {
    $(this).click(function(e) {
      e.preventDefault();
      var url = $(this).attr('href');
      var title = $(this).data('title');
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        animation: false,
        // imageUrl: 'https://unsplash.it/400/200',
        // imageWidth: 400,
        // imageHeight: 200,
        // imageAlt: 'Custom image',
        customClass: 'animated tada',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: url,
            type: "get",
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
                title: 'Oops...',
                text: 'Something went wrong!',
                footer: '<a href>Why do I have this issue?</a>'
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

  $('#edit-product').click(function(e){
    e.preventDefault();
    var url = $(this).data("url"); 
    $.ajax({
      url: url,
      dataType: 'json',
      success: function(product) {

          // get the ajax response data
          var form = $("#product_form");
          var inputField = form.find("[name]");
          $.each(inputField, function(key, val){
            console.log(val.nodeName);
          });
          // for(name in product){
          //  console.log(name);
          // }
          // update modal content here
          // you may want to format data or 
          // update other modal elements here too

          // $('.modal-body').text(data);

          // show modal

          $('#product-modal').modal('show');

      },
      error:function(request, status, error) {
          console.log("ajax call went wrong:" + request.responseText);
      }
    });
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
  $("#edit_attribute_form [name]").on('keyup', function() {
    var input_field = $(this);
    var attributeId = $("#edit_attribute_form [name=id]").val();
    validate_input(input_field, attributeId);
  });

   $("#edit_attribute_form [name]").on('focusout', function() {
    var input_field = $(this);
    var attributeId = $("#edit_attribute_form [name=id]").val();
    validate_input(input_field, attributeId);
  });

  $('.edit_attribute').click(function(e){
    // $(this).click(function(e){
      e.preventDefault();
      var attribute = $(this).data("model");
      var form = $("#edit_attribute_form");
      var idField = form.find("[name=id]");
      var modelField = form.find("[name=model]");
      var skuField = form.find("[name=sku]");
      var colorField = form.find("[name=color]");
      var stockField = form.find("[name=stock]");
      var dropZoneField = form.find(".uploadZone");
      idField.val(attribute.id);
      skuField.val(attribute.sku);
      colorField.val(attribute.color);
      stockField.val(attribute.stock);
      dropZoneField.attr('id', 'dropZone'+attribute.id);
      dropZoneField.addClass('dropzone');

      // show modal
      $("#edit-attribute-modal").modal('show');
    // });
  });

  $("#edit-attribute-modal").on('shown.bs.modal', function (e) {
    var dropZoneField = $(this).find('.uploadZone');
    var dropZoneId = dropZoneField.attr('id');
    dragNDrop(dropZoneId);
  });

  $('#edit-attribute-modal').on('hidden.bs.modal', function (e) {
    var dropZoneField = $(this).find('.uploadZone');
    var dropZoneId = dropZoneField.attr('id');
    $('.dz-preview').remove();
    Dropzone.forElement('#'+dropZoneId).destroy();
    dropZoneField.removeClass('dropzone');
  });

  $('#edit_attribute_form #save').click(function (e) {
    e.preventDefault();
    var formId = $(this).parents('form').attr('id');
    submitForm(formId);
  });
});



