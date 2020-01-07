
@php 
    $data['breadcrumb'] = [
            'Home' => route('admin.dashboard'),
            'Features' => route('admin.features'),
        ];
    $data['title'] = 'Product Features';
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
            <h3 class="card-title d-inline">Features list</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="features" class="table table-bordered table-striped">
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
                @if(!count($features)==0)

                  @foreach($features as $feature)
                    <tr>
                      <td>{{$sl}}</td>
                      <td>{{ $feature['name'] }}</td>
                      <td>{{ $feature['created_at'] }}</td>
                      <td>
                        <a class="btn btn-info" href="{{ route('admin.feature.edit', ['id' => $feature->id]) }}" title="Edit feature"><i class="far fa-edit"></i></a>
                        <a class="btn btn-success" href="{{ route('admin.feature.details', ['id' => $feature->id]) }}" title="feature details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger" href="{{ route('admin.feature.delete', ['id' => $feature->id]) }}" title="Remove feature"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="4" class="text-center">Feature list is empty.</td>
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