
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Product' => route('admin.product.details', ['product' => $attribute->product->id]),
            'Attribute Details' => route('admin.product.attribute.details', ['attribute' => $attribute]),
        ];
    $data['title'] = 'Attribute Details';
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
                    @if($attribute)
                        <div class="card-header" style="background-color:{{$attribute->meta_color}};">
                            <h3 class="card-title">{{ $data['title'] }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.product.attribute.edit', ['attribute' => $attribute]) }}" class="btn btn-tool" title="Edit attribute"><i class="far fa-edit"></i></a>
                                <a href="{{ route('admin.product.attribute.delete', ['attribute' => $attribute]) }}" class="btn btn-tool delete" title="Remove attribute"><i class="far fa-trash-alt"></i></a>
                                <button type="button" class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="far fa-minus-square"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped product-attribute">
                                <thead>
                                    <tr>
                                        <th class="text-right" width="20%">Property</th>
                                        <th width="80%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><th class="text-right">{{ 'SKU' }}</th><td>{{ $attribute['sku'] }}</td></tr>
                                    <tr>
                                        <th class="text-right">{{ 'Color' }}</th>
                                        <td><span class="elevation-2 round-label text-white bg-{{strtolower($attribute->color)}}" style="background-color:{{$attribute->meta_color}};">{{ $attribute['color'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr><th class="text-right">{{ 'Stock' }}</th><td>{{ $attribute['stock'] }}</td></tr>
                                    <tr><th class="text-right">{{ 'Created at' }}</th><td>{{ $attribute->created_at->format('d-m-Y H:i:s') }}</td></tr>
                                    <tr><th class="text-right">{{ 'Updated at' }}</th><td>{{ $attribute->updated_at ? $attribute->updated_at->format('d-m-Y H:i:s') : '' }}</td></tr>
                                    <tr>
                                        <th class="text-right">{{ 'Images' }}</th>
                                        <td class="text-center">
                                            @foreach($attribute['images'] as $image)
                                                <img class="mb-2 elevation-2 round-label" src="{{asset('storage/backend/products/'.$attribute->product->model.'/'.$attribute->sku.'/thumbnail/'.$image)}}">
                                            @endforeach
                                        </td>
                                    </tr>
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

</section>