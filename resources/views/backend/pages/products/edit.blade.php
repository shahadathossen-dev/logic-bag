
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Products' => route('admin.products'),
            'Edit Product' => route('admin.products'),
        ];
    $data['title'] = 'Edit Product';
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
                            <form id="edit_product_form" method="POST" action="{{ route('admin.product.update') }}">
                                
                                @csrf
                     
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="id" value="{{$product['id']}}">
                                        <input id="title" type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{$product['title']}}" placeholder="Title" autofocus required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <input id="model" type="text" class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" name="model" value="{{$product['model']}}" placeholder="Model" readonly>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        @php
                                           $categories = App\Models\Product\Category::all();
                                        @endphp
                                        <select id="category" class="form-control nice-select {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" data-placeholder="Category" required style="width: 100% !important">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" @if($product['category_id'] == $category->id){{'selected'}}@endif>{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                        
                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                    <div class="col-md-6">
                                        @php
                                        $subcategories = App\Models\Product\Category::find($product['category_id'])->subcategories;
                                        @endphp
                                        <select id="subcategory" class="form-control select2 {{ $errors->has('subcategory') ? 'is-invalid' : '' }}" name="subcategory_id" value="{{$product['id']}}" data-placeholder="Subcategory" required style="width: 100% !important">
                                            @foreach($subcategories as $subcategory)
                                                <option value="{{$subcategory->id}}" @if($product['subcategory_id'] == $subcategory->id){{'selected'}}@endif>{{$subcategory->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="price" type="text" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" name="price" value="{{$product['price']}}" placeholder="Price" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <input id="material" type="text" class="form-control {{ $errors->has('material') ? ' is-invalid' : '' }}" name="material" value="{{$product->material}}" placeholder="Material" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>                                    
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="dimension" type="text" class="form-control {{ $errors->has('dimension') ? ' is-invalid' : '' }}" name="dimension" value="{{$product['dimension']}}" placeholder="Dimension" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <input id="weight" type="text" class="form-control {{ $errors->has('weight') ? ' is-invalid' : '' }}" name="weight" value="{{$product['weight']}}" placeholder="Weight" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input id="chamber" type="text" class="form-control {{ $errors->has('chamber') ? ' is-invalid' : '' }}" name="chamber" value="{{$product['chamber']}}" placeholder="Chamber" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <input id="pockets" type="text" class="form-control {{ $errors->has('pockets') ? ' is-invalid' : '' }}" name="pockets" value="{{$product['pockets']}}" placeholder="Pockets" required>

                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div>                                
                                
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        @php
                                           $tags = App\Models\Product\Tag::all();
                                        @endphp
                                        <select id="tags" name="tags[]" class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" multiple="multiple" data-placeholder="Tags" required style="width: 100% !important">
                                            @foreach($tags as $tag)
                                                @if($product->tags()->where('tag_id', $tag->id)->exists())
                                                    <option value="{{$tag->id}}" selected>{{$tag->name}}</option>
                                                @else
                                                    <option value="{{$tag->id}}">{{$tag->name}}</option>
                                                @endif 
                                            @endforeach
                                        </select>
                                        
                                        <span class="invalid-feedback" role="alert"></span>
                                    </div>
                                </div> 
                                
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="editor" placeholder="Place some text here" style="height: 300px; font-size: 14px; line-height: 18px;" >{{$product['description']}}</textarea>

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