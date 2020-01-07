
@extends('backend.layouts.default')

@section('page_subtitle')
Create Password
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
                        <a href="/"><b>Admin Login</b></a>
                    </div>
                    <!-- /.login-logo -->
                    <div class="card" style="background-color: rgba(255,255,255,.5);">
                        <div class="card-body login-card-body">
                            <p class="login-box-msg">Create your passwrod to access your account.</p>

                            <form action="{{route('admin.create.password')}}" method="POST">

                                @csrf
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <div class="form-group has-feedback">
                                    <label for="email" class="">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" placeholder="{{'someone@example.com'}}" required readonly>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback">
                                    <label for="password" class="">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{'Passowrd'}}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group has-feedback">
                                    <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{'Re-type passowrd'}}" name="password_confirmation" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="checkbox icheck">
                                                <input type="checkbox" id="signin" name="signin" value="1">
                                            <label for="remember">
                                                 Sign me in
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
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
