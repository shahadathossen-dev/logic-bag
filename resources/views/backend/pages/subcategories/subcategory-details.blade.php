
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Subcategories' => route('admin.subcategories'),
            $subcategory->title => route('admin.subcategory.details', ['id' => $subcategory->id])
        ];
    $data['title'] = 'Subcategories';
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
                            <table id="subcategory" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-right" width="20%">Property</th>
                                        <th width="80%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><th class="text-right">{{ 'Category' }}</th><td>{{ $subcategory->category->title }}</td></tr>
                                    <tr><th class="text-right">{{ 'Title' }}</th><td>{{ $subcategory->title }}</td></tr>
                                    <tr><th class="text-right">{{ 'Created at' }}</th><td>{{ $subcategory->created_at->format('H:i:s d-m-Y') }}</td></tr>
                                    <tr><th class="text-right">{{ 'Updated at' }}</th><td>{{ $subcategory->updated_at->format('H:i:s d-m-Y') }}</td></tr>
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
