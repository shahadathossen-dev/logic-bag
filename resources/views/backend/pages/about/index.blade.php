
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'About Page' => route('admin.page.about-us'),
        ];
    $data['title'] = 'About Page';
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
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">About Page</h3>
            @if (session('status'))
                <span class="alert alert-success" role="alert">
                    {{ session('status') }}
                </span>
            @elseif (session('warning'))
                <span class="alert alert-danger" role="alert">
                    {{ session('warning') }}
                </span>
            @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @if ($content->content)
                <a href="{{route('admin.page.about-us.content.edit')}}" id="edit" class="btn btn-info" type="button" title="Update Page Content"><i class="fas fa-tags"></i> Update Page Content</a>
            @else
                <a href="{{route('admin.page.about-us.content.create')}}" id="edit" class="btn btn-info" type="button" title="Add Page Content"><i class="fas fa-tags"></i> Add Page Content</a>
            @endif
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
    
</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

</section>
@endsection