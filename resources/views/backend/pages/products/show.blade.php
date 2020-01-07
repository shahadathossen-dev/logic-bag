
@php 
    $data['breadcrumb'] = [
            'Home' => route('admin.dashboard'),
            'Products' => route('admin.products'),
            'Product' => route('admin.products'),
        ];
    $data['title'] = 'Product Details';
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
                    @if($product)
                    <div class="card-header">
                        <h3 class="card-title">{{ $data['title'] }}</h3>

                        <div class="card-tools">
                            @section('controlbar-menu')
                                @if ($product->hasFeature())
                                    <button id="update_feature" class="btn btn-info btn-block" type="button" data-toggle="modal" data-target="#feature-modal" title="Update product feature"><i class="fas fa-tags"></i> Update Feature</button>
                                @else
                                    <button id="add_feature" class="btn btn-info btn-block" type="button" data-toggle="modal" data-target="#feature-modal"title="Add product feature"><i class="fas fa-tags"></i> Add Feature</button>
                                @endif
                                @if (!$product->hasDiscount())
                                    <button id="add_discount" class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#discount-modal" title="Add product disocunt"><i class="fas fa-percentage"></i> Add Discount</button>
                                @else
                                    <a id="remove_discount" class="btn btn-danger btn-block" href="{{route('admin.discount.delete', ['discount' => $product->discount])}}" type="button" title="Remove product disocunt"><i class="fas fa-percentage"></i> Remove Discount</a>
                                @endif
                                @if (!$product->isPublished())
                                    <a class="btn btn-success btn-block" href="{{ route('admin.product.publish',["id" => $product->id]) }}" title="Publish this product"><i class="fas fa-certificate"></i> Publish</a>
                                @endif
                                <a class="btn btn-info btn-block" href="{{route('admin.product.meta', ['model' => $product->model])}}" title="Edit Meta"><i class="far fa-eye"></i> Show Meta</a>
                                <a class="btn btn-info btn-block" href="{{route('admin.product.meta.edit', ['model' => $product->model])}}" title="Edit Meta"><i class="far fa-eye"></i> Edit Meta</a>
                                <a class="btn btn-info btn-block" href="{{route('admin.product.report', ['model' => $product->model])}}" title="Edit Meta"><i class="far fa-eye"></i> Show Report</a>
                                <a class="btn btn-info btn-block" href="{{route('admin.product.preview', ['category' => strtolower($product->category->title), 'subcategory' => str_slug(strtolower($product->subcategory->title)), 'model' => $product->model, 'slug' => $product->meta->slug])}}" title="Publish this product"><i class="far fa-eye"></i> Preview</a>
                                <a class="btn btn-primary btn-block" href="{{route('admin.product.reviews', ['id' => $product->id])}}" title="Product reviews"><i class="far fa-star"></i> Reviews</a>
                            @endsection
                            <button id="add_attribute" type="button" data-toggle="modal" data-target="#attribute-modal" class="btn btn-tool" title="Add new attribute"><i class="far fa-plus-square"></i></button>
                            <a class="btn btn-tool" href="{{ route('admin.product.edit', ['id' => $product['id']]) }}" title="Edit product"><i class="far fa-edit"></i></a>
                            <button class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="far fa-minus-square"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="product" class="table table-bordered table-striped mb-3">
                            <thead>
                                <tr>
                                    <th class="text-right" width="20%">Property</th>
                                    <th width="80%">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><th class="text-right">{{ 'Title' }}</th><td>{{ $product['title'] }}</td></tr>
                                <tr><th class="text-right">{{ 'Model' }}</th><td>{{ $product['model'] }}</td></tr>
                                <tr><th class="text-right">{{ 'Price' }}</th><td>{{ 'BDT '.number_format($product->price,2) }}</td></tr>
                                <tr><th class="text-right">{{ 'Category' }}</th><td>{{ $product->category->title }}</td></tr>
                                <tr><th class="text-right">{{ 'Subcategory' }}</th><td>{{ $product->subcategory->title }}</td></tr>
                                <tr><th class="text-right">{{ 'Material' }}</th><td>{{ $product->material }}</td></tr>
                                <tr><th class="text-right">{{ 'Dimension' }}</th><td>{{ implode(' x ', explode(',', $product->dimension)) }}</td></tr>
                                <tr><th class="text-right">{{ 'Weight' }}</th><td>{{ number_format((float)$product->weight, 3, '.', '')." kg" }}</td></tr>
                                <tr><th class="text-right">{{ 'Chamber' }}</th><td>{{ $product->chamber }}</td></tr>
                                <tr><th class="text-right">{{ 'Pockets' }}</th><td>{{ $product->pockets }}</td></tr>
                                <tr><th class="text-right">{{ 'Tags' }}</th>
                                    <td>@foreach($product->tags as $tag)
                                            <span class="label label-info elevation-2 round-label">{{$tag->name}}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                @if ($product->hasDiscount())
                                <tr><th class="text-right">{{ 'Discount' }}</th><td>{{($product->discount->discount*100)}}%</td></tr>
                                @endif

                                @if ($product->hasFeature())
                                <tr><th class="text-right">{{ 'Feature' }}</th><td><span class="label @if($product->isFeatured() || $product->isTopRated()){{'label-success'}}@elseif($product->isNew()){{'label-primary'}}@elseif($product->isHot()){{'label-danger'}}@elseif($product->isOnSale()){{'label-warning'}}@endif elevation-2 round-label">{{($product->feature->name)}}</span></td></tr>
                                @endif
                                <tr><th class="text-right">{{ 'Description' }}</th><td><?php echo $product['description']; ?></td></tr>
                            </tbody>
                        </table>
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                @foreach($product->attributes as $attribute)
                                <div class="col-md-6 attribute-group">
                                    <div class="card card-primary">
                                        <div class="card-header text-white" style="background-color:{{$attribute->meta_color}};">
                                            <h3 class="card-title">Product Attribute</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="far fa-minus-square"></i></button>
                                                <a id="" href="{{ route('admin.product.attribute.edit', ['attribute' => $attribute]) }}" class="btn btn-tool edit_attribute" title="Edit attribute"><i class="far fa-edit"></i></a>
                                                <a href="{{ route('admin.product.attribute.delete', ['attribute' => $attribute]) }}" class="btn btn-tool delete" title="Remove attribute"><i class="far fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped product-attribute">
                                                <thead>
                                                    <tr>
                                                        <th class="text-right" width="20%">Property</th>
                                                        <th width="80%">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @if($attribute)
                                                    <tr><th class="text-right">{{ 'SKU' }}</th><td>{{ $attribute['sku'] }}</td></tr>
                                                    <tr>
                                                        <th class="text-right">{{ 'Color' }}</th>
                                                        <td><span class="elevation-2 round-label text-white bg-{{strtolower($attribute->color)}}" style="background-color:{{$attribute->meta_color}};">{{ $attribute['color'] }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr><th class="text-right">{{ 'Stock' }}</th><td>{{ $attribute['stock'] }}</td></tr>
                                                    <tr>
                                                        {{-- <th class="text-right">{{ 'Stock' }}</th> --}}
                                                        <td colspan="2" class="text-center">
                                                        @foreach($attribute['images'] as $image)
                                                            <img class="mb-2 elevation-2 round-label" src="{{asset('storage/backend/products/'.$product->model.'/'.$attribute->sku.'/thumbnail/'.$image)}}">
                                                        @endforeach
                                                        </td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<!-- /.content-wrapper -->

<!-- Quick View Modal -->
<div class="modal animated zoomIn" id="float-modal" tabindex="-1" role="dialog" aria-labelledby="float-modal" aria-hidden="true">
    
</div>

<div class="modal animated zoomIn" id="attribute-modal" tabindex="-1" role="dialog" aria-labelledby="add_attribute" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg" role="form">
        <div class="modal-content">
            <div class="modal-body quick-view-gallery" style="padding: 0;">
                <form id="attribute_form" method="POST" action="{{ route('admin.product.attribute.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 attribute-group">
                            <div class="card card-primary card-outline" style="margin-bottom: 0px !important;">
                                <div class="card-header">
                                    <h3 class="card-title">Add Attribute</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="fa fa-minus-circle"></i></button>
                                        <button type="button" class="btn btn-tool" data-dismiss="modal" aria-label="Close" title="Discard Attribute"><i class="fa fa-times-circle"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <input type="hidden" name="product_id" value="{{$product['id']}}">
                                            <input type="hidden" name="model" value="{{$product['model']}}">
                                            <input type="text" name="sku" class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" value="{{ old("sku") }}" placeholder="SKU" required>

                                            <span class="invalid-feedback" role="alert"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="stock" class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" value="{{ old("stock") }}" placeholder="Stock" required>

                                            <span class="invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <input type="text" name="color" class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" value="{{ old("color") }}" placeholder="Color" required>

                                            <span class="invalid-feedback" role="alert"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="text" name="meta_color" class="form-control {{ $errors->has('meta_color') ? 'is-invalid' : '' }}" value="{{ old("meta_color") }}" placeholder="Color" required>

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

<div class="modal animated zoomIn" id="feature-modal" tabindex="-1" role="dialog" aria-labelledby="edit_feature" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-md" role="form">
        <div class="modal-content">
            <div class="modal-body" style="padding: 0;">
                <form id="feature_form" method="POST" action="{{ route('admin.product.feature.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline" style="margin-bottom: 0px !important;">
                                <div class="card-header">
                                    <h3 class="card-title">Update Product Feature</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="fa fa-minus-circle"></i></button>
                                        <button type="button" class="btn btn-tool" data-dismiss="modal" aria-label="Close" title="Discard Feature"><i class="fa fa-times-circle"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="product_id" value="{{$product['id']}}">
                                            @php
                                               $features = App\Models\Product\Feature::all();
                                            @endphp
                                            <select id="feature" class="form-control nice-select {{ $errors->has('feature_id') ? 'is-invalid' : '' }}" name="feature_id" value="{{ old('feature_id') }}" data-placeholder="Features" required>
                                                <option value="0">None</option>
                                                @foreach($features as $feature)
                                                    <option value="{{$feature->id}}" @if($product['feature_id'] == $feature->id){{'selected'}}@endif>{{$feature->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="invalid-feedback" role="alert"></span>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row mb-0 text-center">
                                        <div class="col-md-12">
                                            <input type="submit" name="submit" id="save" value="Save Feature" class="btn btn-success">
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

<div class="modal animated zoomIn" id="discount-modal" tabindex="-1" role="dialog" aria-labelledby="edit_feature" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog modal-md" role="form">
        <div class="modal-content">
            <div class="modal-body" style="padding: 0;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline" style="margin-bottom: 0px !important;">
                            <div class="card-header">
                                <h3 class="card-title">Add Product Discount</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="fa fa-minus-circle"></i></button>
                                    <button type="button" class="btn btn-tool" data-dismiss="modal" aria-label="Close" title="Discard Discount"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="form_form" method="POST" action="{{ route('admin.product.discount.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="model" value="{{$product['model']}}">

                                            <input id="discount" type="number" step="0.01" min="0" class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" value="{{ old('discount') }}" required autofocus>

                                            @if ($errors->has('discount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('discount') }}</strong>
                                                </span>
                                            @endif

                                            <span class="invalid-feedback" role="alert"></span>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row mb-0 text-center">
                                        <div class="col-md-12">
                                            <input type="submit" name="submit" id="save" value="Save Feature" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Quick View Modal -->

@include('backend.layouts.modules.controlbar')

@endsection
