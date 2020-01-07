
@php
    $page['title'] = 'Verify Email';
@endphp

@extends('layouts.default')

@section('page_subtitle')
    {{$page['title']}}
@endsection

@section('content')
<div class="container error-container">
    <div class="error-header text-center">
        <h3>Verify Email</h3>
        <img class="animated fadeInUp" src="{{asset('resource/img/newsletter/send.png')}}" alt="">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    {{ __('Verify Your Email Address') }}
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    <p>Before proceeding, please check your email for a verification link.</p>
                    <p>If you did not receive the email please, click the button below to request another verification mail.</p>
                    
                    <a class="btn btn-primary" href="{{ route('verification.resend') }}">{{ __('Resend verification email') }}</a>
                </div>
                <div class="card-footer error-footer">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
