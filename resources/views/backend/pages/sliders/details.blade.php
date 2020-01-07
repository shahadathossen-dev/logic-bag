
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Sliders' => route('admin.sliders'),
            'Slider Details' => route('admin.slider.details', ['id' => $slider->id])
        ];
    $data['title'] = 'Slider Details';
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
                            <table id="slider" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-right" width="20%">Property</th>
                                        <th width="80%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><th class="text-right">{{ 'Item Model' }}</th><td>{{ $slider->model }}</td></tr>
                                    <tr><th class="text-right">{{ 'Item Title' }}</th><td>{{ $slider->item->title }}</td></tr>
                                    <tr><th class="text-right">{{ 'Item Image' }}</th><td><img class="img-fluid" src="{{asset('/public/storage/backend/products/'.$slider->model.'/'.$slider->item->attributeFirst()['sku'].'/thumbnail/'.$slider->item->attributeFirst()['images'][0])}}" alt="{{$slider->item->attributeFirst()['images'][0].' image'}}"></td></tr>
                                    <tr><th class="text-right">{{ 'Slider Image' }}</th><td><img class="img-fluid" src="{{asset('/public/storage/backend/sliders/thumbnail/'.$slider->slider)}}" alt="{{$slider->slider.' image'}}"></td></tr>
                                    <tr><th class="text-right">{{ 'Created at' }}</th><td>{{ $slider->created_at->format('H:i d-m-Y') }}</td></tr>
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
