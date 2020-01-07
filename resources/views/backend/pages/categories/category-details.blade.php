
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Categories' => route('admin.categories'),
            'Category Details' => route('admin.category.details', ['id' => $category->id]),
        ];
    $data['title'] = 'Category Details';
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
                            <table id="category" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-right" width="20%">Property</th>
                                        <th width="80%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><th class="text-right">{{ 'Title' }}</th><td>{{ $category->title }}</td></tr>
                                    <tr><th class="text-right">{{ 'Created at' }}</th><td>{{ $category->created_at->format('H:i:s d-m-Y') }}</td></tr>
                                    <tr><th class="text-right">{{ 'Updated at' }}</th><td>{{ $category->updated_at->format('H:i:s d-m-Y') }}</td></tr>
                                </tbody>
                            </table>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Subcategories</h5>
                                </div>
                                <div class="card-body">
                                    <table id="subcategories" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Subcategory Title</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                          $sl = 1;
                                        @endphp
                                        @if(count($category->subcategories) > 0)
                                            @foreach($category->subcategories as $subcategory)
                                            <tr>
                                                <td>{{$sl}}</td>
                                                <td>{{ $subcategory->title }}</td>
                                                <td>{{ $subcategory->created_at->format('H:i:s d-m-Y') }}</td>
                                                <td>{{ $subcategory->updated_at->format('H:i:s d-m-Y') }}</td>
                                                <td>
                                                    <a class="btn btn-info" href="{{ route('admin.subcategory.edit', ['id' => $subcategory->id]) }}" title="Edit Subcategory"><i class="far fa-edit"></i></a>
                                                    <a class="btn btn-success" href="{{ route('admin.subcategory.details', ['id' => $subcategory->id]) }}" title="Subcategory details"><i class="far fa-check-square"></i></a>
                                                    <a class="btn btn-danger" href="{{ route('admin.subcategory.delete', ['id' => $subcategory->id]) }}" title="Remove Subcategory"><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                            @php
                                              $sl++;
                                            @endphp
                                            @endforeach
                                        @else
                                            <tr class="empty">
                                                <td colspan="4" class="text-center">Subcategory list is empty.</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Subcategory Title</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Add New Subcategory</h5>
                                </div>
                                <div class="card-body">
                                    @if (session('status'))
                                        <div class="col-md-6 offset-md-4">
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        </div>
                                    @elseif (session('warning'))
                                        <div class="col-md-6 offset-md-4">
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('warning') }}
                                            </div>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('admin.subcategory.store') }}" enctype="multipart/form-data">

                                        @csrf
                                        <input type="hidden" name="category_id" value="{{$category->id}}">
                                        <div class="form-group row">
                                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Subcategory Title') }}</label>

                                            <div class="col-md-6">
                                                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required>

                                                @if ($errors->has('title'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('title') }}</strong>
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
            </div>
        </div>
    </section>
    
</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

@endsection
