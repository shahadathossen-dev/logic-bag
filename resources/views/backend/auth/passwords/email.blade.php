@extends('backend.layouts.default')

@section('page_subtitle')
Reset Password
@endsection

@section('content')
<section class="" style="background-image: url({{asset('backend/img/bgs/login-bg.jpg')}});">
    <div class="container">
        <div class="row justify-content-between" style="height: calc(100vh);">
            <div class="col-md-6 col-lg-4 align-self-end" style="height: 100px;">
                <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn d-inline float-left" src="{{ asset('backend/img/logicbag-logo.png') }}" alt="Logo Icon" style="max-width: 100px;padding-top: 15px;padding-right: 10px;">
                <div class="copy animated fadeIn d-inline float-left" style="color: #fff;">
                    <h4>{{ config('app.name') }}</h4>
                    <p>{{ ('Make the better solution.') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 align-self-center">
                <div class="login-box">
                    <div class="login-logo">
                        <a href="/"><b>Reset Password</b></a>
                    </div>
                    <!-- /.login-logo -->
                    <div class="card" style="background-color: rgba(255,255,255,.5);">
                        <div class="card-body login-card-body">
                            @if (session('status'))
                                <div class="alert alert-success text-center" role="alert">
                                    {{ session('status') }}
                                </div>
                            @else
                                <p class="login-box-msg">Enter your email to get a password reset link</p>
                            @endif

                            <form action="{{ route('admin.password.email') }}" method="POST">

                                @csrf
                                
                                <div class="form-group has-feedback">
                                    
                                    <label for="email" class="col col-form-label">{{ __('E-mail Address') }}</label>
                                    <input type="text" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="fa fa-envelope invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                     @endif

                                </div>

                                <div class="form-group row mb-0 text-center">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.Password-reset-card -->
                </div>
                <!-- /.Password-reset-box -->
            </div>
        </div>
    </div>
</section>
@endsection
