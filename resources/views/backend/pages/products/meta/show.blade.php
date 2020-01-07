
@php 
    $data['breadcrumb'] = [
            'Home' => route('admin.dashboard'),
            'Product' => route('admin.product.details', ['id' => $meta->product->id]),
            'Meta' => route('admin.product.meta', ['model' => $meta]),
        ];
    $data['title'] = 'Product Meta';
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
                    @if($meta)
                    <div class="card-header">
                        <h3 class="card-title">{{ $data['title'] }}</h3>

                        <div class="card-tools">
                            <a id="" href="{{route('admin.product.meta.edit', ['model' => $meta])}}" class="btn btn-tool edit_meta" title="Edit product meta"><i class="far fa-edit"></i></a>
                            <button class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="far fa-minus-square"></i></button>
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times-circle"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="meta" class="table table-bordered table-striped mb-3">
                            <thead>
                                <tr>
                                    <th class="text-right" width="20%">Property</th>
                                    <th width="80%">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><th class="text-right">{{ 'Title' }}</th><td>{{ $meta->product->title }}</td></tr>
                                <tr><th class="text-right">{{ 'Model' }}</th><td>{{ $meta->product->model }}</td></tr>
                                <tr><th class="text-right">{{ 'Slug' }}</th><td>{{ $meta->slug }}</td></tr>
                                <tr><th class="text-right">{{ 'Description' }}</th><td>{{ $meta->description }}</td></tr>
                                <tr><th class="text-right">{{ 'Images' }}</th><td>
                                    @php
                                        $attribute = $meta->product->attributeFirst();
                                    @endphp
                                    @foreach($attribute->images as $image)
                                        <img class="mb-2 elevation-2 round-label" src="{{asset('storage/backend/products/'.$meta->product->model.'/'.$attribute->sku.'/thumbnail/'.$image)}}">
                                    @endforeach
                                </td></tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

@endsection
