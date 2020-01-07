
@php
    $page['breadcrumb'] =   [
            'Home' => route('welcome'),
            'User Registration' => route('register'),
        ];
    $page['title'] = 'User Registration';
@endphp

@extends('layouts.default')

@section('page_subtitle')
    {{$page['title']}}
@endsection

@section('meta_description')
Create your account to discover all the great features we bring to you.
@endsection

@section('content')

<!-- Featured Product Area -->
<section id="register" class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('resource/img/bgs/login.jpg') }}">
     <div class="register-overlay">
         <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-lg-6 col-xl-5">
                    <div class="login-section">
                        <div class="login-title text-center">
                            <h4 class="text-uppercase">create account</h4>
                            <p>Create your account to discover all the great features we bring to you.</p>
                        </div>
                        <div class="login-form">
                            <form class="" action="{{ route('register') }}" method="POST">

                                @csrf
                                
                                <div class="col-lg-12 form-group">
                                    <input class="form-control {{ $errors->has('fname') ? 'is-invalid' : '' }}" name="fname" type="text" placeholder="First Name" value="{{Old('fname')}}">

                                    @if ($errors->has('fname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fname') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input class="form-control {{ $errors->has('lname') ? 'is-invalid' : '' }}" name="lname" type="text" placeholder="Last Name" value="{{Old('lname')}}">

                                    @if ($errors->has('lname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lname') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="email" placeholder="Email address" value="{{Old('email')}}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" type="password" placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password_confirmation" type="password" placeholder="Re-Password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input type="hidden" name="subscribe" value="0">
                                    <input type="checkbox" id="subscribe" name="subscribe" value="1">
                                    <label for="subscribe">Signup for newsletter</label>
                                </div>
                                <div class="col-lg-12 form-group mb-0">
                                    <button type="submit" value="submit" class="btn btn-success form-control">Register</button>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="create-account">
                                        <p><span>Don't have time?</span> login with:</p>
                                        <div class="social-login">
                                            <a class="btn btn-block login-facebook login-links" href="{{route('social.login', ['driver' => 'facebook'])}}" title="Facebook login">
                                                <i class="fab fa-facebook-square"></i> facebook
                                            </a>
                                            
                                            {{-- <a class="login-googleplus login-links" href="{{route('social.login', ['driver' => 'google'])}}" title="Google+ login">
                                                <i class="fab fa-google-plus-square"></i>
                                            </a> --}}
                                            {{-- <a class="login-twitter login-links" href="#" title="Twitter login">
                                                <i class="fab fa-twitter"></i>
                                            </a> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</section>
<!-- End Featured Product Area -->


@endsection
