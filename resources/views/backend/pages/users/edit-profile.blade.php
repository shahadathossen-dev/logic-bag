
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Users' => route('admin.users'),
            'Edit Profile' => route('admin.profile.edit'),
        ];
    $data['title'] = 'Edit Profile';
@endphp

@extends('backend.layouts.default')

@section('page_title')
{{ $data['title'] }}
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
                            <h3 class="card-title">{{ __('Update your profile') }}</h3>

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
                            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group row">
                                    <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="fname" type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="@if($user->fname !== NULL){{$user->fname}}@else{{ old('fname') }}@endif" placeholder="First Name" required autofocus>

                                        @if ($errors->has('fname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lname" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="lname" type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="@if($user->lname !== NULL){{$user->lname}}@else{{ old('lname') }}@endif" placeholder="Last Name" required>

                                        @if ($errors->has('lname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('lname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" id="dob" name="dob" value="@if($user->profile['dob'] !== NULL){{$user->profile['dob']}}@else{{ old('dob') }}@endif" min="1980-01-01" max="2015-01-01" required>

                                        @if ($errors->has('dob'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('dob') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number') }}</label>
                                    <div class="col-md-6">
                                        <input type="tel" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="@if($user->profile['phone'] !== NULL){{$user->profile['phone']}}@else{{ old('lname') }}@endif" placeholder="01xxx-xxxxxx" pattern="[0-9]{5}-[0-9]{6}" required />

                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="education" class="col-md-4 col-form-label text-md-right">{{ __('Education') }}</label>

                                    <div class="col-md-6">
                                        <input id="education" type="text" class="form-control{{ $errors->has('education') ? ' is-invalid' : '' }}" name="education" value="@if($user->profile['education'] !== NULL){{$user->profile['education']}}@else{{ old('fname') }}@endif" placeholder="Highest Degree, University, Location, Year" required>

                                        @if ($errors->has('education'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('education') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="@if($user->profile['address'] !== NULL){{$user->profile['address']}}@else{{ old('fname') }}@endif" placeholder="Street Address, Union, District, Country" required>

                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="skills" class="col-md-4 col-form-label text-md-right">{{ __('Skills') }}</label>

                                    <div class="col-md-6">
                                        <input id="skills" type="text" class="form-control{{ $errors->has('skills') ? ' is-invalid' : '' }}" name="skills" value="@if($user->profile['skills'] !== NULL){{$user->profile['skills']}}@else{{ old('fname') }}@endif" placeholder="PHP, SEO, Laravel, Javascript etc." required>

                                        @if ($errors->has('skills'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('skills') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="notes" class="form-control{{ $errors->has('notes') ? ' is-invalid' : '' }}" name="notes" placeholder="About yourself in brief">@if($user->profile['notes'] !== NULL){{$user->profile['notes']}}@else{{ old('fname') }}@endif</textarea>
                                        
                                        @if ($errors->has('notes'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('notes') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
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

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>
                                    <div class="col-md-4 input-group">
                                        <div class="custom-file w-100">
                                            <input type="file" class="custom-file-input" id="avatar" name="avatar">
                                            <label class="custom-file-label" for="avatar"></label>
                                        </div>
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Update Profile') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img class="" id="selectedImage" width="100" height="120" src="{{asset('storage/backend/users/medium/'.$user->profile['avatar'])}}" alt="your image"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

@endsection
