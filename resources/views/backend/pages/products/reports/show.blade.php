
@php 
    $data['breadcrumb'] = [
            'Home' => route('admin.dashboard'),
            'Product' => route('admin.product.details', ['id' => $report->product->id]),
            'Report' => route('admin.product.report', ['model' => $report->model]),
        ];
    $data['title'] = 'Product Report';
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
                    @if($report)
                    <div class="card-header">
                        <h3 class="card-title">{{ $data['title'] }}</h3>

                        <div class="card-tools">
                            <button class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="far fa-minus-square"></i></button>
                            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times-circle"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="report" class="table table-bordered table-striped mb-3">
                            <thead>
                                <tr>
                                    <th class="text-right" width="20%">Property</th>
                                    <th width="80%">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><th class="text-right">{{ 'Title' }}</th><td>{{ $report->product->title }}</td></tr>
                                <tr><th class="text-right">{{ 'Model' }}</th><td>{{ $report->product->model }}</td></tr>
                                <tr><th class="text-right">{{ 'Price' }}</th><td>{{ 'BDT '.number_format($report->product->price,2) }}</td></tr>
                                <tr><th class="text-right">{{ 'Sales' }}</th><td>{{ $report->sales }}</td></tr>
                                <tr><th class="text-right">{{ 'Revenue' }}</th><td>{{ 'BDT '.number_format($report->revenue,2) }}</td></tr>
                                @if ($report->product->hasDiscount())
                                <tr><th class="text-right">{{ 'Discount' }}</th><td>{{($report->poduct->discount->discount*100)}}%</td></tr>
                                @endif

                                @if ($report->product->hasFeature())
                                <tr><th class="text-right">{{ 'Feature' }}</th><td><span class="label @if($report->product->isFeatured() || $report->product->isTopRated()){{'label-success'}}@elseif($report->product->isNew()){{'label-primary'}}@elseif($product->isHot()){{'label-danger'}}@elseif($product->isOnSale()){{'label-warning'}}@endif elevation-2 round-label">{{($report->product->feature->name)}}</span></td></tr>
                                @endif
                                
                                <tr><th class="text-right">{{ 'Images' }}</th><td>
                                    @php
                                        $attribute = $report->product->attributeFirst();
                                    @endphp
                                    @foreach($attribute->images as $image)
                                        <img class="mb-2 elevation-2 round-label" src="{{asset('storage/backend/products/'.$report->product->model.'/'.$attribute->sku.'/thumbnail/'.$image)}}">
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
