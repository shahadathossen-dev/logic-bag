
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

  var url = "http://logicbagbd.com/backend/category/"+category+"/subcategories";

    $.ajax({
      type: "GET",
      url: url,
      success: function(subcategories){
        $('#subcategory').html(" ");
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
    url: "http://logicbagbd.com/backend/product/pictures/upload",

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
            url: "http://logicbagbd.com/backend/product/picture/delete",
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

function verifyBforeUpload(myDropzone){
  
} 

function validate_input(input_field){

    var _token = $("form input[name=_token]").val();
    var name = input_field.attr("name");
    var value = input_field.val();
    var formData = {
      '_token' : _token, 
      [name] : value,
    }

    return $.ajax({
      url: "http://logicbagbd.com/backend/product/input/validate",
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
                  // window.location.replace("http://logicbagbd.com/backend/products");
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

$(document).ready(function(){
    //group add limit
    var maxGroup = 10;
    
    //add more fields group
    $(".addMore").click(function(){
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
    $("body").on("click",".remove", function(){

      $.ajax({
      url: "http://logicbagbd.com/backend/product/pictures/delete",
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

    // Product form validate input fields
  $("[name]").each(function(){
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

  // $("#product_form").submit(function(e) {
 //     e.preventDefault();
 //     if (!(images.length > 0)) {
 //       $(".dropzone").addClass("is-invalid");
  //      var msg = '<strong>Product pictures are required!</strong>';
  //      $(".dropzone").siblings('.invalid-feedback').html(msg);
  //     } else {
 //       var _token = $("input[name='_token']").val();
 //         var title = $("input[name='title']").val();
 //         var model = $("input[name='model']").val();
 //         var category = $("select[name='category']").val();
 //         var subcategory = $("select[name='subcategory']").val();
 //         var price = $("input[name='price']").val();
  //      var chamber = $("input[name='chamber']").val();
  //        var dimension = $("input[name='dimension']").val();
  //        var weight = $("input[name='weight']").val();
  //        var tags = $("select[name^='tags']").val();
  //        var description = $("textarea[name='description']").val();
  //        var sku = $("input[name=sku]").val();
  //        var color = $("input[name=color]").val();
  //        var stock = $("input[name=stock]").val();
  //        $("input[name^=images]").val(images);
  //        var images_array = new Array($("input[name^=images]").val());

  //        $.ajax({
  //          url: "http://logicbagbd.com/backend/product/store",
  //          type: "POST",
  //          dataType: 'json', 
  //          data: { 
  //            '_token': _token,
  //            'title': title,
  //            'model': model,
  //            'category': category,
  //            'subcategory': subcategory,
  //            'price': price,
  //            'chamber': chamber,
  //            'dimension': dimension,
  //            'weight': weight,
  //            'tags': tags,
  //            'description': description,
  //            'sku': sku,
  //            'color': color,
  //            'stock': stock,
  //            'images': images_array,
  //          },
  //          success: function(response){
  //            swal('Success', response['status'], 'success', {
  //                  buttons: [
  //                      false, true
  //                  ]
  //                })
  //                .then((value) => {
  //                  window.location.replace("http://logicbagbd.com/backend/products");
  //                });
  //          },
  //          error: function (xhr) {
  //                 if (xhr.status == 422) {
  //                    var errors_obj = JSON.parse(xhr.responseText);
  //                    var errors = errors_obj.errors;
  //                    for (name in errors) {
  //                      if (name == 'subcategory' || name == 'tags') {
  //                          $("[name="+name+"]").siblings('.select2.select2-container').addClass("is-invalid");
  //                        $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
  //                      } else if (name == 'description') {
  //                        console.log('description');
  //                          $("[name="+name+"]").siblings('#mceu_17').addClass("is-invalid");
  //                        $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
  //                      } else {
  //                          $("[name="+name+"]").addClass("is-invalid");
  //                        $("[name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
  //                      }
  //                    }
  //                 } else {
  //                    if (xhr['warning']) {
  //                  $(".alert-danger").html(xhr['warning']);
  //                  $(".alert-danger").removeClass("d-none");
  //                }
  //                 }
  //              }
  //      });
  //    }
  // });

  // $('#edit-product').click(function(e){
  //   e.preventDefault();
  //     var url = $(this).data("url"); 
  //     $.ajax({
  //         url: url,
  //         dataType: 'json',
  //         success: function(product) {

  //             // get the ajax response data
  //             var form = $("#product_form");
  //             var inputField = form.find("[name]");
  //             $.each(inputField, function(key, val){
  //               console.log(val.nodeName);
  //             });
  //             // for(name in product){
  //             //  console.log(name);
  //             // }
  //             // update modal content here
  //             // you may want to format data or 
  //             // update other modal elements here too

  //             // $('.modal-body').text(data);

  //             // show modal

  //             $('#product-modal').modal('show');

  //         },
  //         error:function(request, status, error) {
  //             console.log("ajax call went wrong:" + request.responseText);
  //         }
  //     });
  // });

  
});

// New Product Js


$(function(){

  var category = $('#product_form #category').val();
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

$('#product_form #category').change(function(){
  var category = $(this).val();
  embedSubcategory(category);
});

function embedSubcategory(category)
{

  var url = "http://logicbagbd.com/backend/category/"+category+"/subcategories";

    $.ajax({
      type: "GET",
      url: url,
      success: function(subcategories){
        $('#product_form #subcategory').html(" ");
        $.each(subcategories, function(id, title){
          $('#product_form #subcategory').append(
                    "<option value='"+id+"'>"+title+"</option>"
            );

        });
      }
    });
}

const productImages = [];
Dropzone.autoDiscover = false;
$('#ProductDropZone').dropzone({
    autoProcessQueue: false,
    paramName: "files",
    addRemoveLinks: true,
    maxFilesize: 10, // MB
    maxFiles: 12,
    uploadMultiple: true,
    parallelUploads: 10,
    url: "http://logicbagbd.com/backend/product/pictures/upload",

  init: function() {
      var myDropzone = this;
      var submit = $("#submit_product");
      submit.click(function(e){
          e.preventDefault();
          e.stopPropagation();
          myDropzone.processQueue();
      });
    myDropzone.on('addedfile', function(files) {
      model = $("#product_form input[name=model]").val();
      token = $('#product_form input[name=_token]').val();
          sku = $("#product_form input[name=sku]").val();
          
      if (model == "" || sku == "") {
          if (model == "") {
            $("#product_form input[name=model], #product_form .dropzone").addClass('is-invalid');
            var msg = '<strong>Product "Model" is required before uploading pictures!</strong>';
            $("#product_form input[name=model], #product_form .dropzone").next('.invalid-feedback').html(msg);
          }
          if (sku == "") {
            $("#product_form input[name=sku], #product_form .dropzone").addClass('is-invalid');
            var msg = '<strong>Product "SKU" is required before uploading pictures!</strong>';
            $("#product_form input[name=sku], #product_form .dropzone").next('.invalid-feedback').html(msg);
          }
      } else {
        modelField = $("#product_form input[name=model]");
          var skuField = $("#product_form input[name=sku]");
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
        productImages.push(response[i]);
        }
        $("#product_form .dropzone").addClass('is-valid');
        $("#product_form input[name^=images]").val(productImages);
        submitProductForm();
      });

      myDropzone.on('errormultiple', function(file, response) {
          console.log(response);
      });

      myDropzone.on("removedfile", function(file) {
      if (!(model == "" || sku == "")) {
            var name = file.name;
        $.ajax({
            url: "http://logicbagbd.com/backend/product/picture/delete",
          type: "POST",
          data: { 
            'sku': sku,
            'model': model,
            '_token': token,
            'name': name,
          },
            success: function(response){
              productImages.splice( $.inArray(name, productImages), 1);
              $("#product_form input[name^=images]").val(productImages);
            },
            error: function(response){
              console.log(response);
            }
        });
      }
    });
  }
});

function validate_input(input_field){

    var _token = $("#product_form input[name=_token]").val();
    var name = input_field.attr("name");
    var value = input_field.val();
    var formData = {
      '_token' : _token, 
      [name] : value,
    }

    return $.ajax({
      url: "http://logicbagbd.com/backend/product/input/validate",
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
                      $("#product_form [name="+name+"]").addClass("is-invalid");
                      $("#product_form [name="+name+"]").siblings('#mceu_17').css("border-color", "red");
                    $("#product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                } else if (name == 'category_id' || name == 'subcategory_id') {
                    $("#product_form [name="+name+"]").siblings('.select2.select2-container').addClass("is-invalid");
                    $("#product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                    $("#product_form [name="+name+"]").siblings('.select2.select2-container').css({
                      "border" : "1px solid red", 
                      "border-radius" : "5px"
                    });
                } else {
                  $("#product_form [name="+name+"]").addClass("is-invalid");
                      $("#product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name]);
                }
                } else {
                  if (name == 'description') {
                      $("#product_form [name="+name+"]").removeClass("is-invalid");
                      $("#product_form [name="+name+"]").siblings('#mceu_17').css("border-color", "green");
                    $("#product_form [name="+name+"]").siblings('.invalid-feedback').html("");
                      $("#product_form [name="+name+"]").addClass("is-valid");
                } else if (name == 'category_id' || name == 'subcategory_id' || '') {
                    $("#product_form [name="+name+"]").siblings('.select2.select2-container').removeClass("is-invalid");
                    $("#product_form [name="+name+"]").siblings('.invalid-feedback').html("");
                    $("#product_form [name="+name+"]").siblings('.select2.select2-container').css({
                      "border" : "1px solid green", 
                      "border-radius" : "5px"
                    });
                } else {
                  $("#product_form [name="+name+"]").removeClass("is-invalid");
                      $("#product_form [name="+name+"]").siblings('.invalid-feedback').html("");
                  $("#product_form [name="+name+"]").addClass("is-valid");
                } 
                }
            }
        }
    });
} 

function validate_edit_input(input_field){

    var _token = $("#edit_product_form input[name=_token]").val();
    var id = $("#edit_product_form input[name=id]").val();
    var name = input_field.attr("name");
    var value = input_field.val();
    var formData = {
      '_token' : _token, 
      [name] : value,
      'id' : id,
    }

    return $.ajax({
      url: "http://logicbagbd.com/backend/product/input/validate",
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
                      $("#edit_product_form [name="+name+"]").addClass("is-invalid");
                      $("#edit_product_form [name="+name+"]").siblings('#mceu_17').css("border-color", "red");
                    $("#edit_product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                } else if (name == 'category_id' || name == 'subcategory_id') {
                    $("#edit_product_form [name="+name+"]").siblings('.select2.select2-container').addClass("is-invalid");
                    $("#edit_product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                    $("#edit_product_form [name="+name+"]").siblings('.select2.select2-container').css({
                      "border" : "1px solid red", 
                      "border-radius" : "5px"
                    });
                } else {
                  $("#edit_product_form [name="+name+"]").addClass("is-invalid");
                      $("#edit_product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name]);
                }
                } else {
                  if (name == 'description') {
                      $("#edit_product_form [name="+name+"]").removeClass("is-invalid");
                      $("#edit_product_form [name="+name+"]").siblings('#mceu_17').css("border-color", "green");
                    $("#edit_product_form [name="+name+"]").siblings('.invalid-feedback').html("");
                      $("#edit_product_form [name="+name+"]").addClass("is-valid");
                } else if (name == 'category_id' || name == 'subcategory_id' || '') {
                    $("#edit_product_form [name="+name+"]").siblings('.select2.select2-container').removeClass("is-invalid");
                    $("#edit_product_form [name="+name+"]").siblings('.invalid-feedback').html("");
                    $("#edit_product_form [name="+name+"]").siblings('.select2.select2-container').css({
                      "border" : "1px solid green", 
                      "border-radius" : "5px"
                    });
                } else {
                  $("#edit_product_form [name="+name+"]").removeClass("is-invalid");
                      $("#edit_product_form [name="+name+"]").siblings('.invalid-feedback').html("");
                  $("#edit_product_form [name="+name+"]").addClass("is-valid");
                } 
                }
            }
        }
    });
} 

function submitProductForm(){

    if (!(productImages.length > 0)) {
      $("#product_form .dropzone").addClass("is-invalid");
      var msg = '<strong>Product pictures are required!</strong>';
      $("#product_form .dropzone").siblings('.invalid-feedback').html(msg);
    } else {
        var form = $('form#product_form');
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
                  // window.location.reload(true);
                  window.location.replace("http://logicbagbd.com/backend/products");
                });
            },
            error: function (xhr) {
                if (xhr.status == 422) {
                    var errors_obj = JSON.parse(xhr.responseText);
                    var errors = errors_obj.errors;
                    for (name in errors) {
                      if (name == 'category_id' || name == 'subcategory_id' || name == 'tags') {
                          $("#product_form [name="+name+"]").siblings('.select2.select2-container').addClass("is-invalid");
                        $("#product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                      } else if (name == 'description') {
                          $("#product_form [name="+name+"]").siblings('#mceu_17').addClass("is-invalid");
                        $("#product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                      } else {
                          $("#product_form [name="+name+"]").addClass("is-invalid");
                        $("#product_form [name="+name+"]").siblings('.invalid-feedback').html(errors[name][0]);
                      }
                    }
                } else {
                    if (xhr['warning']) {
                    $("#product_form .alert-danger").html(xhr['warning']);
                    $("#product_form .alert-danger").removeClass("d-none");
                  }
                }
            }
      });
    }
}

$(document).ready(function(){
    
    //remove fields group
    $("body").on("click",".remove", function(){

      $.ajax({
      url: "http://logicbagbd.com/backend/product/pictures/delete",
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

    // Product form validate input fields
  $("#product_form [name]").each(function(){
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

  $("#edit_product_form [name]").each(function(){
      var name = $(this).attr("name");
      var input_field = $(this);
      if (name == "category_id" || name == "subcategory_id" || name == "tags") {
         $(this).on('change', function(){
            validate_edit_input(input_field);
          });
      } else {
          $(this).on('keyup', function(){
            validate_edit_input(input_field);
          });

          $(this).on('focusout', function(){
            validate_edit_input(input_field);
          });
      }
  });
  
  $('.edit_attribute').each(function(){
    $(this).click(function(e){
      e.preventDefault();
      // $('#edit-attribute-modal').remove();
      var attribute = $(this).data("model"); 
      var form = $("#edit_attribute_form");
      var idField = form.find("[name=id]");
      var modelField = form.find("[name=model]");
      var skuField = form.find("[name=sku]");
      var colorField = form.find("[name=color]");
      var stockField = form.find("[name=stock]");
      var dropZoneField = form.find(".dropzone");
      var model = modelField.val();
      var sku = attribute.sku;
      idField.val(attribute.id);
      skuField.val(attribute.sku);
      colorField.val(attribute.color);
      stockField.val(attribute.stock);
      // dropZoneField.attr('id', sku);

      // show modal
      $("#edit-attribute-modal").modal('show');
    });
  });
  
});

  $(modal).on('shown.bs.modal', function (e) {
    // Initialize Dropzone
      Dropzone.autoDiscover = false;
      const files = [];
      $('#attributeDropZone').dropzone({
          autoProcessQueue: false,
          paramName: "files",
          addRemoveLinks: true,
          maxFilesize: 10, // MB
          maxFiles: 12,
          uploadMultiple: true,
          parallelUploads: 10,
          url: "http://logicbagbd.com/backend/product/pictures/upload",

        init: function() {
          var myDropzone = this;
          // var form = $("#edit_attribute_form");
          // var skuField = form.find("[name=sku]");
          // var modelField = form.find("[name=model]");
          $.get('http://logicbagbd.com/backend/attribute/images/'+modelField.val()+'/'+skuField.val(), function(data) {
            console.log(data);
              // $.each(data.images, function (key, value) {
              //     var file = {name: value.original, size: value.size};
              //     myDropzone.options.addedfile.call(myDropzone, file);
              //     myDropzone.options.thumbnail.call(myDropzone, file, 'images/icon_size/' + value.server);
              //     myDropzone.emit("complete", file);
              //     photo_counter++;
              //     $("#photoCounter").text( "(" + photo_counter + ")");
              // });
          });
          var submit = $("#save_attribute");
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
              files.push(response[i]);
            }
            $("input[name^=images]").val(files);
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
                url: "http://logicbagbd.com/backend/product/picture/delete",
                type: "POST",
                data: { 
                  'sku': sku,
                  'model': model,
                  '_token': token,
                  'name': name,
                },
                success: function(response){
                  files.splice( $.inArray(name, files), 1);
                  $("input[name^=images]").val(files);
                },
                error: function(response){
                  console.log(response);
                }
              });
            }
          });
        }
      });
  });

// Latest


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

  var url = "http://logicbagbd.com/backend/category/"+category+"/subcategories";

    $.ajax({
      type: "GET",
      url: url,
      success: function(subcategories){
        $('#subcategory').html(" ");
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
    url: "http://logicbagbd.com/backend/product/pictures/upload",

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
            url: "http://logicbagbd.com/backend/product/picture/delete",
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
    console.log(id);
    return $.ajax({
      url: "http://logicbagbd.com/backend/product/input/validate",
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
                  // window.location.replace("http://logicbagbd.com/backend/products");
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
      url: "http://logicbagbd.com/backend/product/pictures/delete",
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
    // $(this).on('keyup', function(){
      validate_input(input_field, attributeId);
      console.log(attributeId);
    // });

    // $(this).on('focusout', function(){
    //   validate_input(input_field, attributeId);
    // });
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

  

function dragNDrop(dropZoneId) {
  const files = [];
  Dropzone.autoDiscover = false;
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
      url: "http://logicbagbd.com/backend/product/pictures/upload",

    init: function() {
      var myDropzone = this;
      var form = $("#edit_attribute_form");
      var skuField = form.find("[name=sku]");
      var modelField = form.find("[name=model]");
      model = modelField.val();
      sku = skuField.val();
      token = $('form input[name=_token]').val();
      $.get('http://logicbagbd.com/backend/attribute/images/'+model+'/'+sku, function(data) {
          $.each(data, function (key, value) {
              var file = {name: value.original, size: value.size};
              myDropzone.options.addedfile.call(myDropzone, file);
              myDropzone.options.thumbnail.call(myDropzone, file, value.server);
              myDropzone.emit("complete", file);
              files.push(file.name);
          });
          myDropzone.options.maxFiles = myDropzone.options.maxFiles - data.length;
          $("input[name^=images]").val(files);
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
          files.push(response[i]);
        }
        $("input[name^=images]").val(files);
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
            url: "http://logicbagbd.com/backend/product/picture/delete",
            type: "POST",
            data: { 
              'sku': sku,
              'model': model,
              '_token': token,
              'name': name,
            },
            success: function(response){
              files.splice( $.inArray(name, files), 1);
              $("input[name^=images]").val(files);
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
  $('#edit-attribute-modal').on('hidden.bs.modal', function (e) {
    
    var dropZoneField = $(this).find('.uploadZone');
    var dropZoneId = dropZoneField.attr('id');
    Dropzone.forElement('#'+dropZoneId).destroy();
    dropZoneField.removeClass('dropzone');
  });
});


