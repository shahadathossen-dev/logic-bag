
@php
    $page['title'] = 'User Login';
@endphp

@extends('layouts.default')

@section('page_subtitle')
    {{$page['title']}}
@endsection

@section('meta_description')
Reset user password - {{ config('app.name')}}
@endsection

@section('content')

<div class="container error-container">
    <div class="error-header text-center">
        <h3>Reset Password Email</h3>
        <img class="animated fadeInUp" src="{{asset('resource/img/newsletter/send.png')}}" alt="">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">{{ __('Give your email to get a password reset link.') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0 text-left">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer error-footer">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
