
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  	<!-- CSRF Token -->
  	<meta name="csrf-token" content="{{ csrf_token() }}">
  	
	<meta name="title" description="
	 	@if (View::hasSection('page_title'))
	     	@yield('page_title') - 
	    @endif {{ config('app.name') }}">
	<meta name="keywords" description="Logic bag, Laptop Bag, Hand Bag, Leather Bag, Purse Bag">
	<meta name="description" description="@yield('meta_description')">


  	<title>
	    @if (View::hasSection('page_title'))
	     	@yield('page_title') - 
	    @endif
	    {{ config('app.name') }}
	</title>

 	<!-- Favicon -->
	<link rel="icon" type="image/png" href="{{asset('resource/img/icons/favicon.png')}}"/>

 	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  	
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

	<!-- iCheck -->
	<link rel="stylesheet" href="{{asset('backend/plugins/iCheck/square/blue.css')}}">
	
	<!-- Select2 -->
  	<link rel="stylesheet" href="{{asset('backend/plugins/select2/select2.min.css')}}">

	<!-- Jquery Nice Select -->
	<link rel="stylesheet" href="{{asset('backend/plugins/nice-select/css/nice-select.css')}}">
	
	<!-- Jquery Color Picker -->
	<link rel="stylesheet" href="{{asset('backend/plugins/colorpicker/bootstrap-colorpicker.min.css')}}">

	<!-- DataTables -->
  	<link rel="stylesheet" href="{{asset('backend/plugins/datatables/dataTables.bootstrap4.css')}}">

	<!-- TinyMCE Editor -->
  	<link rel="stylesheet" href="{{asset('backend/plugins//bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  	
  	<!-- Dropzone JS -->
  	<link rel="stylesheet" href="{{asset('backend/plugins/dropzone/dropzone.css')}}">

  	<!-- Sweet Alert JS -->
  	<link rel="stylesheet" href="{{asset('backend/plugins/sweetalert/sweetalert2.min.css')}}">
	
	<!-- Animate CSS -->
	<link rel="stylesheet" href="{{asset('vendor/animate/animate.css')}}">
	
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	<!-- Theme style -->
	<link rel="stylesheet" href="{{asset('backend/css/adminlte.css')}}">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{asset('backend/css/custom.css')}}">

</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
	
