
@php
    $authUser = Auth::guard('admin')->user();

    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Users' => route('admin.users'),
            'Create User' => route('admin.user.create'),
        ];

    $data['title'] = 'Create User';
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
                            <h3 class="card-title">{{ __('Create New User') }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus-circle"></i></button>
                                <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times-circle"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
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
                            <form method="POST" action="{{ route('admin.user.store') }}">

                                @csrf

                                <div class="form-group row">
                                    <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="fname" type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ old('fname') }}" required autofocus>

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
                                        <input id="lname" type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{ old('lname') }}" required>

                                        @if ($errors->has('lname'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('lname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

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

                                <div class="form-group row">
                                    <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                                    @php
                                        $roles = App\Models\Backend\User\Role::all();
                                    @endphp
                                    <div class="col-md-6">
                                        <select class="form-control nice-select" name="role_id" required>
                                            @foreach ($roles as $role)
                                            <option value="{{$role->id}}"
                                             @if ($role->id == 1)
                                                {{'disabled'}}
                                            @endif>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Create') }}
                                        </button>
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
