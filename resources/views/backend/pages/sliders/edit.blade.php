
@php 
    $data['breadcrumb'] =   [
        'Home' => route('admin.dashboard'),
        'Sliders' => route('admin.sliders'),
        'Edit Sldier' => route('admin.slider.edit', ['id' => $slider->id]),
    ];
    $data['title'] = 'Edit Sldier';
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
                            <form method="POST" action="{{ route('admin.slider.update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$slider->id}}">
                                <div class="form-group row">
                                    <label for="model" class="col-md-3 col-form-label text-md-right">{{ __('Sldier Item') }}</label>

                                    <div class="col-md-6">
                                        <input id="model" type="text" class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" name="model" value="{{ $slider->model }}" required autofocus>

                                        @if ($errors->has('model'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('model') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="slider" class="col-md-3 col-form-label text-md-right">{{ __('Slider image') }}</label>

                                    <div class="col-md-6">
                                        <input id="subcategory_thumb" type="file" class="form-control{{ $errors->has('slider') ? ' is-invalid' : '' }}" name="image" value="{{ $slider->image }}">

                                        @if ($errors->has('slider'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('slider') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <img class="" id="selectedImage" width="100" height="120" src="{{ asset('/storage/backend/sliders/thumbnail/'.$slider->image) }}" alt="Slider image"/>
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
