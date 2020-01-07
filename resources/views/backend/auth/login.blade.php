
@php 
    $data['title'] = 'Admin Login';
@endphp

@extends('backend.layouts.default')

@section('page_title')
{{ $data['title'] }}
@endsection

@section('content')
<section class="" style="background-image: url({{asset('backend/img/bgs/login-bg.jpg')}});">
    <div class="container">
        <div class="row justify-content-between" style="height: calc(100vh);">
            <div class="col-md-6 col-lg-4 align-self-end" style="height: 100px;">
                <img class="img-responsive pull-left logo hidden-xs animated flip d-inline float-left" src="{{ asset('backend/img/logicbag-logo.png') }}" alt="Logo Icon" style="max-width: 100px;padding-top: 15px;padding-right: 10px;">
                <div class="copy animated fadeIn d-inline float-left" style="color: #fff;">
                    <h4>{{ config('app.name') }}</h4>
                    <p>{{ ('Make the better solution.') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 align-self-center">
                <div class="login-box">
                    <div class="login-logo">
                        <a href="/"><b>Admin Login</b></a>
                    </div>
                    <!-- /.login-logo -->
                    <div class="card" style="background-color: rgba(255,255,255,.5);">
                        <div class="card-body login-card-body">
                            @if (session('status'))
                                <div class="col-md-6 offset-md-4">
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @elseif (session('warning'))
                                <div class="col-md-6 offset-md-4">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('warning') }}
                                    </div>
                                </div>
                            @endif
                            <p class="login-box-msg">Please, Sign in to start your session.</p>

                            <form action="{{ route('admin.login') }}" method="POST">

                                @csrf

                                <div class="form-group has-feedback">
                                    
                                    <label for="username" class="col-sm-4 col-form-label">{{ __('Username') }}</label>
                                    <input type="text" id="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="fa fa-envelope invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                     @endif

                                </div>
                                <div class="form-group has-feedback">
                                    <label for="password" class="col-sm-4 col-form-label">{{ __('Password') }}</label>
                                    <input type="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password" name="password">

                                    @if ($errors->has('password'))
                                        <span class="fa fa-lock invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                     @endif
                                     
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="checkbox icheck">
                                                <input type="checkbox" id="remember" name="remember">
                                            <label for="remember">
                                                 Remember Me
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                            <p class="mb-1">
                                <a href="{{ route('admin.password.request') }}">I forgot my password</a>
                            </p>
                        </div>
                        <!-- /.login-card-body -->
                    </div>
                </div>
                <!-- /.login-box -->
            </div>
        </div>
    </div>
</section>
@endsection
