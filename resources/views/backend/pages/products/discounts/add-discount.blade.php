
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Discounts' => route('admin.products.discounts'),
            'Add Batch Discounts' => route('admin.products.discount.store'),
        ];
    $data['title'] = 'Add Batch Discount';
    $products = App\Models\Product::doesntHave('discount')->published()->get();
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
                            @if (session('status'))
                                <div class="col text-center">
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @elseif (session('warning'))
                                <div class="col text-center">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('warning') }}
                                    </div>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('admin.products.discount.store') }}">

                                @csrf

                                <div class="form-group row">

                                    <div class="col-md-4">
                                        <label for="product_id" class="col-form-label text-md-right">{{ __('Discounted Products') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select id="product_id" class="form-control select2" type="select" multiple="multiple" name="product_id[]">
                                            @foreach($products as $product)
                                                <option value="{{$product->model}}">{{$product->model}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="amount" class="col-form-label text-md-right">{{ __('Discount Amount') }}</label>
                                    </div>
                                            
                                    <div class="col-md-8">
                                        <input id="amount" type="number" step="0.01" min="0" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" required>

                                        @if ($errors->has('amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Add') }}
                                        </button>
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
