
@php
    $page['title'] = 'User Login';
@endphp

@extends('layouts.default')

@section('page_subtitle')
    {{$page['title']}}
@endsection

@section('meta_description')
Log in to your account to discover all the great features we bring to you.
@endsection

@section('content')

<!-- Featured Product Area -->
<section id="login" class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('resource/img/bgs/login.jpg') }}">
     <div class="login-overlay">
         <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-md-6 col-lg-5 col-xl-5">
                    <div class="login-section">
                        <div class="login-title text-center">
                            <h4 class="text-uppercase">log in your account</h4>
                            <p>Log in to your account to discover all the great features we bring to you.</p>
                        </div>
                        <div class="login-form">
                            <form class="" action="{{ route('login') }}" method="POST">
                                
                                @csrf

                                <div class="col-lg-12 form-group">
                                    <label for="username">Email</label>
                                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="username" type="email" name="email" placeholder="Email address" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="col-lg-12 form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" type="password" name="password" placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <div class="col-lg-12 form-group mb-0">
                                    <input type="checkbox" id="remember" name="remember">
                                    <label for="remember">Keep me logged in</label>
                                    <a href="{{ route('password.request') }}"><p class="">Forgot your password ?</p></a>
                                </div>

                                <div class="col-lg-12 form-group mb-0">
                                    <button type="submit" value="submit" class="btn btn-success btn-block">Login</button>
                                </div>

                                <div class="col-lg-12 text-center" >
                                    <div class="create-account">
                                        <p >New user ?</p> <a href="{{ route('register') }}">Create account</a> <span>or login with:</span>
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
