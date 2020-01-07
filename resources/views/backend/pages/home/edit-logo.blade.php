
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Trade Marks' => route('admin.page.trade-marks'),
            'Update Logo' => route('admin.page.trade-marks.logo.edit'),
        ];
    $data['title'] = 'Update Logo';
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
                <div class="col-md-10">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{ end($data) }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus-circle"></i></button>
                                <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times-circle"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.page.trade-marks.logo.update') }}" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group row">
                                    <label for="type" class="col-md-2 col-form-label text-md-right">{{ __('Mark Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="type" type="text" class="form-control" name="type" value="logo" readonly>
                                        @if ($errors->has('type'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="content" class="col-md-2 col-form-label text-md-right">{{ __('Logo image') }}</label>

                                    <div class="col-md-6">
                                        <input id="logo_thumb" type="file" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" value="{{ old('content') }}" required>

                                        @if ($errors->has('content'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-offset-2 col-md-6 text-center">
                                        <img class="" id="selectedImage" width="100" height="120" src="{{ asset('/storage/frontend/bgs/'.$logo->content) }}" alt="Logo image"/>
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
