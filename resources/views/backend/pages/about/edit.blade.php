
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'About Page' => route('admin.page.about-us'),
            'Edit Content' => route('admin.page.about-us.content.edit'),
        ];
    $data['title'] = 'Edit Content';
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
                            <form method="POST" action="{{ route('admin.page.about-us.content.update') }}">

                                @csrf

                                <div class="form-group row d-none">
                                    <div class="col-md-6">
                                        <input id="page" type="text" class="form-control" name="page" value="{{ old('page') }}" value="@if($content->page){{$content->page}}@endif" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea id="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" placeholder="Place some text here" style="height: 300px; font-size: 14px; line-height: 18px;" >@if($content->content){{$content->content}}@endif</textarea>
                                        @if ($errors->has('content'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-block btn-primary">
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
