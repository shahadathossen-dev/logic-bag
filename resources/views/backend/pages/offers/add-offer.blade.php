
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Offers' => route('admin.offers'),
            'Add Offer' => route('admin.offer.add'),
        ];
    $data['title'] = 'Add Offer';
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
                            <form method="POST" action="{{ route('admin.offer.store') }}" enctype="multipart/form-data">

                                @csrf
                                
                                <div class="form-group row">
                                    <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Offer Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="model" class="col-md-3 col-form-label text-md-right">{{ __('Offer Item') }}</label>

                                    <div class="col-md-6">
                                        <input id="model" type="text" class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" name="model" value="{{ old('model') }}" required>

                                        @if ($errors->has('model'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('model') }}</strong>
                                            </span>
                                        @endif                                      
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-3 col-form-label text-md-right">
                                        <label for="discount" class="col-form-label text-md-right">{{ __('Discount') }}</label>
                                    </div>
                                            
                                    <div class="col-md-6">
                                        <input id="discount" type="number" step="0.01" min="0" class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" name="discount" value="{{ old('discount') }}" required>

                                        @if ($errors->has('discount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('discount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="expiry_date" class="col-md-3 col-form-label text-md-right">{{ __('Expiry Date') }}</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control {{ $errors->has('expiry_date') ? 'is-invalid' : '' }}" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" required>

                                        @if ($errors->has('expiry_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('expiry_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Add') }}
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
