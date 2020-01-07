
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Products' => route('admin.products'),
            'Add New Product' => route('admin.product.add'),
        ];
    $data['title'] = 'Add New Product';
    $authUser = Auth::guard('admin')->user();
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
                    <form id="product_form" method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
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
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') }}" placeholder="Title" autofocus required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <input id="model" type="text" class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" name="model" value="{{ old('model') }}" placeholder="Model" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        @php
                                           $categories = App\Models\Product\Category::all();
                                        @endphp
                                        <select id="category" class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" value="{{ old('category') }}" data-placeholder="Category" required>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                        
                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <select id="subcategory" class="form-control select2 {{ $errors->has('subcategory') ? 'is-invalid' : '' }}" name="subcategory_id" value="{{ old('subcategory') }}" data-placeholder="Subcategory" required>
                                        </select>
                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                    
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="price" type="text" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" name="price" value="{{ old('price') }}" placeholder="Price" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <input id="material" type="text" class="form-control {{ $errors->has('material') ? ' is-invalid' : '' }}" name="material" value="{{ old('material') }}" placeholder="Material" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>                                                                   
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="dimension" type="text" class="form-control {{ $errors->has('dimension') ? ' is-invalid' : '' }}" name="dimension" value="{{ old('dimension') }}" placeholder="Dimension" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <input id="weight" type="text" class="form-control {{ $errors->has('weight') ? ' is-invalid' : '' }}" name="weight" value="{{ old('weight') }}" placeholder="Weight" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="chamber" type="text" class="form-control {{ $errors->has('chamber') ? ' is-invalid' : '' }}" name="chamber" value="{{ old('chamber') }}" placeholder="Chamber" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <input id="pockets" type="text" class="form-control {{ $errors->has('pockets') ? ' is-invalid' : '' }}" name="pockets" value="{{ old('pockets') }}" placeholder="Pockets" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        @php
                                           $tags = App\Models\Product\Tag::all();
                                        @endphp
                                        <select id="tags" name="tags[]" class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" multiple="multiple" value="" data-placeholder="Tags" required>
                                            @foreach($tags as $tag)
                                                <option value="{{$tag->id}}">{{$tag->name}}</option>
                                            @endforeach
                                        </select>
                                        
                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea id="meta_description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="meta_description" placeholder="Place short description for the product" style="height: 100px; font-size: 14px; line-height: 18px;" required>{{ old('meta_description') }}</textarea>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="Place some text here" style="height: 300px; font-size: 14px; line-height: 18px;" >{{ old('description') }}</textarea>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>
                                <div class="row attribute-field">
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
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="sku" class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" value="{{ old("sku") }}" placeholder="SKU" required>

                                                        <span class="invalid-feedback" role="alert"></span>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <input type="text" name="stock" class="form-control {{ $errors->has('stocks') ? 'is-invalid' : '' }}" value="{{ old("stock") }}" placeholder="Stock" required>

                                                        <span class="invalid-feedback" role="alert"></span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <input type="text" name="color" class="form-control {{ $errors->has('colors') ? 'is-invalid' : '' }}" value="{{ old("color") }}" placeholder="Color" required>

                                                        <span class="invalid-feedback" role="alert"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="meta_color" class="form-control {{ $errors->has('meta_color') ? 'is-invalid' : '' }}" value="{{ old("meta_color") }}" placeholder="Meta Color" required>

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
                                                            <button class="btn bg-light float-right start-upload"></button>
                                                        </div>
                                                        <span class="invalid-feedback" role="alert"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0 text-center">
                                    <div class="col-md-12">
                                        <input type="submit" name="submit" id="submit" value="Save Product" class="btn btn-success">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

@endsection
