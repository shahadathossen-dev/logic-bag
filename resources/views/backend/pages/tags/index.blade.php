
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Tags' => route('admin.tags'),
        ];
    $data['title'] = 'Tags';
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
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">Tags list</h3>
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
            <table id="tags" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Title</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $sl = 1;
                @endphp
                @if(!count($tags)==0)

                  @foreach($tags as $tag)
                    <tr>
                      <td>{{$sl}}</td>
                      <td>{{ $tag['name'] }}</td>
                      <td>{{ $tag['created_at'] }}</td>
                      <td>
                        <a class="btn btn-info" href="{{ route('admin.tag.edit', ['tag' => $tag]) }}" title="Edit tag"><i class="far fa-edit"></i></a>
                        <a class="btn btn-success" href="{{ route('admin.tag.details', ['tag' => $tag]) }}" title="tag details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger" href="{{ route('admin.tag.delete', ['tag' => $tag]) }}" title="Remove tag"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="4" class="text-center">Tag list is empty.</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Sl No.</th>
                  <th>Title</th>
                  <th>Created at</th>
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