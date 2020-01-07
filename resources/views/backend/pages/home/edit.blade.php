
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Trade Marks' => route('admin.page.trade-marks'),
            'Add Trade' => route('admin.page.trade-marks.type.create', ['trade' => $trade]),
        ];
    $data['title'] = 'Add '.ucfirst($trade->type);
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
                            <form method="POST" action="{{ route('admin.page.trade-marks.type.update', ['trade' => $trade]) }}" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group row">
                                    <label for="type" class="col-md-2 col-form-label text-md-right">{{ __('Trade Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="type" type="text" class="form-control" name="type" value="{{$trade->type}}" readonly>
                                        @if ($errors->has('type'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="content" class="col-md-2 col-form-label text-md-right">{{ __('Trade Content') }}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="content" value="{{$trade->content}}" autofocus>

                                        @if ($errors->has('content'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-offset-2 col-md-6 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit') }}
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
