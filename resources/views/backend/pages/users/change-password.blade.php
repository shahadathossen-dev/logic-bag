@php
  $data = ['Home', 'Users', 'Change Password'];
@endphp

@extends('backend.layouts.default')

@section('page_title')
{{ end($data) }}
@endsection

@section('content')

@include('backend.layouts.modules.navbar')
@include('backend.layouts.modules.sidebar')
@include('backend.layouts.modules.content-header')

<section class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Update your password') }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus-circle"></i></button>
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times-circle"></i></button>
                        </div>
                  </div>
                    <!-- /.card-header -->
                    <div class="card-body justify-content-center">
                        @if (session('status'))
                            <div class="col">
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            </div>
                        @elseif (session('warning'))
                            <div class="col">
                                <div class="alert alert-danger" role="alert">
                                    {{ session('warning') }}
                                </div>
                            </div>
                        @endif
                        <p class="login-box-msg">Put your old password in order to create your new password</p>

                        <form action="{{route('admin.password.update')}}" method="POST">

                            @csrf
                            <div class="form-group has-feedback">
                                <label for="old_password" class="">{{ __('Old Password') }} <i class="fas fa-key"></i></label>
                                <input id="old_password" type="password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" placeholder="{{'Old Passeword'}}" required>

                                @if ($errors->has('old_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback">
                                <label for="password" class="">{{ __('Password') }} <i class="fas fa-key"></i></label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{'Passowrd'}}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback">
                                <label for="password-confirm" class="">{{ __('Confirm Password') }} <i class="fas fa-key"></i></label>
                                <input id="password-confirm" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{'Re-type passowrd'}}" name="password_confirmation" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
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
</section>
</div>
@endsection
