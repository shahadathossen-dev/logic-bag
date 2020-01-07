@php
    $data['breadcrumb'] =   [
          'Home' => route('admin.dashboard'),
          'Roles' => route('admin.roles'),
      ];
    $data['title'] = 'Roles';
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
      <div class="col-md-10">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">Roles list</h3>
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
            <table id="roles" class="table table-bordered table-striped">
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
                @if(!count($roles)==0)

                  @foreach($roles as $role)
                    <tr>
                      <td>{{$sl}}</td>
                      <td>{{ $role['name'] }}</td>
                      <td>{{ $role->created_at->format('d-m-Y H:i:s') }}</td>
                      <td>{{ $role->updated_at ? $role->updated_at->format('d-m-Y H:i:s') : '' }}</td>
                      <td>
                        <a class="btn btn-info" href="{{ route('admin.role.edit', ['role' => $role]) }}" title="Edit role"><i class="far fa-edit"></i></a>
                        <a class="btn btn-success" href="{{ route('admin.role.details', ['role' => $role]) }}" title="role details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger" href="{{ route('admin.role.delete', ['role' => $role]) }}" title="Remove role"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="4" class="text-center">Role list is empty.</td>
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