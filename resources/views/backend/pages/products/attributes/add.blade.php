
@php 
    $data = ['Home', 'Products', 'Add new attribute'];
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
                <div class="col-md-10">
                    <div class="card-body">
                        
                        <form id="attribute_form" method="POST" action="{{ route('admin.attribute.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 attribute-group">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title">Product Attribute</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="fa fa-minus-circle"></i></button>
                                                <button type="button" class="btn btn-tool remove" data-widget="remove" title="Discard Attribute"><i class="fa fa-times-circle"></i></button>
                                            </div>
                                        </div>
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
                                            <div class="form-group row">
                                                    <input type="hidden" name="product_id" value="{{$product['id']}}">
                                                    <input type="hidden" name="model" value="{{$product['model']}}">
                                                    <div class="col-md-12">
                                                        <input type="text" name="sku" class="form-control {{ $errors->has('skus[]') ? 'is-invalid' : '' }}" value="{{ old("sku") }}" placeholder="SKU" autofocus required>

                                                        <span class="invalid-feedback" role="alert"></span>
                                                    </div>
                                                    
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="color" class="form-control {{ $errors->has('colors') ? 'is-invalid' : '' }}" value="{{ old("color") }}" placeholder="Color" required>

                                                        <span class="invalid-feedback" role="alert"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="stock" class="form-control {{ $errors->has('stocks') ? 'is-invalid' : '' }}" value="{{ old("stock") }}" placeholder="Stock" required>

                                                        <span class="invalid-feedback" role="alert"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <input type="hidden" name="images[]" value="">
                                                        <div id="dropZone" class="dropzone form-control {{ $errors->has('images') ? 'is-invalid' : '' }}">
                                                            <div class="dz-message dz-default needsclick">
                                                                <h3 class="sbold">Drop files here to upload</h3>
                                                                <center>  <i class="far fa-images fa-4x" aria-hidden="true"></i></center>
                                                                
                                                                <span>You can also click to open file browser</span>
                                                            </div>
                                                        </div>
                                                        <span class="invalid-feedback" role="alert"></span>
                                                    </div>
                                                </div>
                                            <div class="form-group row mb-0 text-center">
                                                <div class="col-md-12">
                                                    <input type="submit" name="submit" id="submit" value="Submit Product" class="btn btn-success">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

@endsection
