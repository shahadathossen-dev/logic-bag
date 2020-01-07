
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Product' => route('admin.product.details', ['id' => $meta->product->id]),
            'Edit Meta' => route('admin.product.meta', ['model' => $meta]),
        ];
    $data['title'] = 'Edit Meta';
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
                            <form id="edit_product_meta" method="POST" action="{{ route('admin.product.meta.update') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="id" value="{{$meta['id']}}">
                                        <textarea id="meta_description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="Place short description for the product." style="width: 100%; height: 100px; font-size: 14px; line-height: 18px;" required>{{$meta['description']}}</textarea>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>      
                                                                             
                                <div class="form-group row mb-0 text-center">
                                    <div class="col-md-12">
                                        <input type="submit" name="submit" id="update_product" value="Update Product" class="btn btn-success">
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