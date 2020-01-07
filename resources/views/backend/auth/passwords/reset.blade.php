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
                            <p class="login-box-msg">Enater your email to get a reset link</p>

                            <form action="{{ route('admin.password.update') }}" method="POST">

                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group has-feedback">
                                    
                                    <label for="email" class="col col-form-label">{{ __('E-mail Address') }}</label>
                                    <input type="text" id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="fa fa-envelope invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                     @endif

                                </div>

                                <div class="form-group has-feedback">
                                    <label for="password" class="col-sm-4 col-form-label">{{ __('Password') }}</label>
                                    <input type="password" id="password" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Password" name="password">

                                    @if ($errors->has('password'))
                                        <span class="fa fa-lock invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                     @endif
                                     
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
