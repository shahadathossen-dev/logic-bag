
@php 
    $data['breadcrumb'] =   [
        'Home' => route('admin.dashboard'),
        'Banners' => route('admin.banners'),
        'Edit Banner' => route('admin.banner.edit', ['id' => $banner->id]),
    ];
    $data['title'] = 'Edit Banner';
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
                            <h3 class="card-title">{{ end($data) }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus-circle"></i></button>
                                <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times-circle"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.banner.update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$banner->id}}">
                                <div class="form-group row">
                                    <label for="model" class="col-md-3 col-form-label text-md-right">{{ __('Banner Item') }}</label>

                                    <div class="col-md-6">
                                        <input id="model" type="text" class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" name="model" value="{{ $banner->model }}" required autofocus>

                                        @if ($errors->has('model'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('model') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="banner" class="col-md-3 col-form-label text-md-right">{{ __('Banner image') }}</label>

                                    <div class="col-md-6">
                                        <input id="subcategory_thumb" type="file" class="form-control{{ $errors->has('banner') ? ' is-invalid' : '' }}" name="banner" value="{{ $banner->banner }}">

                                        @if ($errors->has('banner'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('banner') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <img class="" id="selectedImage" width="100" height="120" src="{{ asset('/storage/backend/banners/thumbnail/'.$banner->banner) }}" alt="Banner image"/>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update') }}
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
