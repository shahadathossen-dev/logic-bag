
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Categories' => route('admin.categories'),
        ];
    $data['title'] = 'Categories';
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
    <div class="row justify-content-center">
      <div class="col-10">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">Categories list</h3>
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
            <table id="categories" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Title</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $sl = 1;
                @endphp
                @if(!count($categories)==0)

                  @foreach($categories as $category)
                    <tr>
                      <td>{{$sl}}</td>
                      <td>{{ $category->title }}</td>
                      <td>{{ $category->created_at->format('H:i:s d-m-Y') }}</td>
                      <td>{{ $category->updated_at->format('H:i:s d-m-Y') }}</td>
                      <td>
                        <a class="btn btn-info" href="{{ route('admin.category.edit', ['id' => $category->id]) }}" title="Edit category"><i class="far fa-edit"></i></a>
                        <a class="btn btn-success" href="{{ route('admin.category.details', ['id' => $category->id]) }}" title="Category details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger" href="{{ route('admin.category.delete', ['id' => $category->id]) }}" title="Remove category"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="4" class="text-center">Category list is empty.</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Sl No.</th>
                  <th>Title</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
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