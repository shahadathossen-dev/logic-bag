
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Subcategories' => route('admin.subcategories'),
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
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">Subcategories list</h3>
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
            <table id="subcategories" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Subcategory Title</th>
                  <th>Category</th>
                  <th>Created at</th>
                  <th>Updated at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $sl = 1;
                @endphp
                @if(count($subcategories) > 0)
                  @foreach($subcategories as $category => $subcategoriesArray)
                  @foreach($subcategoriesArray as $value)
                    @php
                      $subcategory = $value['subcategory'];
                    @endphp
                    <tr>
                      <td>{{$sl}}</td>
                      <td>{{ $subcategory->title }}</td>
                      <td>{{$category}}</td>
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
                  <th>Category</th>
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