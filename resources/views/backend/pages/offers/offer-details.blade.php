
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Offers' => route('admin.offers'),
            'Offer Details' => route('admin.offer.details', ['id' => $offer->id])
        ];
    $data['title'] = 'Offer Details';
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
                            <table id="deals-item" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-right" width="20%">Property</th>
                                        <th width="80%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><th class="text-right">{{ 'Model' }}</th><td>{{ $offer->model }}</td></tr>
                                    <tr><th class="text-right">{{ 'Title' }}</th><td>{{ $offer->item->title }}</td></tr>

                                    <tr><th class="text-right">{{ 'Image' }}</th><td><img class="img-fluid" src="{{asset('/public/storage/backend/products/'.$offer->model.'/'.$offer->item->attributeFirst()['sku'].'/thumbnail/'.$offer->item->attributeFirst()['images'][0])}}" alt="{{$offer->item->attributeFirst()['images'][0].' image'}}"></td></tr>
                                    <tr><th class="text-right">{{ 'Price' }}</th><td>{{'BDT '.number_format($offer->item->absolutePrice(),2)}}</td></tr>
                                    <tr><th class="text-right">{{ 'Expires' }}</th><td>@php
                                        echo Carbon\Carbon::parse($offer->expiry_date)->format('d-m-Y');
                                    @endphp</td></tr>
                                    <tr><th class="text-right">{{ 'Created at' }}</th><td>{{ $offer->created_at->format('H:i d-m-Y') }}</td></tr>
                                </tbody>
                            </table>
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
