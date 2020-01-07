
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Tags' => route('admin.tags'),
            'Edit Tag' => route('admin.tag.details', ['tag' => $tag]),
        ];
    $data['title'] = 'Tag Details';
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
                            <h3 class="card-title">{{ $data['title'] }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus-circle"></i></button>
                                <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times-circle"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tag" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-right" width="20%">Property</th>
                                        <th width="80%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><th class="text-right">{{ 'Title' }}</th><td>{{ $tag->name }}</td></tr>
                                    <tr><th class="text-right">{{ 'Created at' }}</th><td>{{ $tag->created_at->format('H:i:s d-m-Y') }}</td></tr>
                                    <tr><th class="text-right">{{ 'Updated at' }}</th><td>{{ $tag->updated_at ? $tag->updated_at->format('H:i:s d-m-Y') : '' }}</td></tr>
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
