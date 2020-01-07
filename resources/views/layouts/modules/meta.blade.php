<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<meta name="title" description="@yield('page_subtitle')- {{ config('app.name') }}">
	<meta name="keywords" description="@if(View::hasSection('meta_keywords'))@yield('meta_keywords')@endif">
	<meta name="description" description="@if(View::hasSection('meta_description'))@yield('meta_description')@endif">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
	    @if (View::hasSection('page_subtitle'))
	     	@yield('page_subtitle')
	    @endif
	     - {{ config('app.name') }}
 	</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:500,500i,600,600i,700" rel="stylesheet"> 
	
	<!-- Fonts -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/bootstrap/css/bootstrap.css')}}">

	<!-- Animate CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/animate/animate.css')}}">

	<!-- Owl Carousel -->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/owlcarousel/css/owl.carousel.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/owlcarousel/css/owl.theme.default.min.css')}}">

	<!-- Magnific Popup -->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/magnific-popup-master/css/magnific-popup.css')}}">

	<!-- Nice Select -->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/nice-select/css/nice-select.css')}}">
  	
	<!-- Sweet Alert -->
  	<link rel="stylesheet" href="{{asset('backend/plugins/sweetalert/sweetalert2.min.css')}}">

	<!-- Magnifier Js -->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/magnifier/css/magnifier.css')}}">

	<!-- custom style -->
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}">

	<!-- Fav Icon -->
	<link rel="icon" type="image/png" href="{{asset('resource/img/icons/favicon.png')}}"/>


</head>

<body>
	
@include('layouts.modules.header')
	