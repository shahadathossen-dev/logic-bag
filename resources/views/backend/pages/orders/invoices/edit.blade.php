
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Product' => route('admin.product.details', ['product' => $attribute->product->id]),
            'Edit Attribute' => route('admin.product.attribute.edit', ['attribute' => $attribute]),
        ];
    $data['title'] = 'Edit Attribute';
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
            <div class="col-md-8">
                @if($attribute)               
                <div class="row">
                    <div class="col-md-12 attribute-group">
                        <div class="card card-primary card-outline" style="margin-bottom: 0px !important;">
                            <div class="card-header">
                                <h3 class="card-title">Edit Attribute</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse" title="Minimize window"><i class="fa fa-minus-circle"></i></button>
                                    <button type="button" class="btn btn-tool" data-dismiss="modal" aria-label="Close" title="Discard Attribute"><i class="fa fa-times-circle"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('backend.pages.partials.edit-attribute-form')
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

@endsection
