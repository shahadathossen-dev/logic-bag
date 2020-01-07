
@php 
  $data['breadcrumb'] =   [
          'Home' => route('admin.dashboard'),
          'Users' => route('admin.users'),
          'Trash' => route('admin.profile'),
      ];
  $data['title'] = 'User List';

  $authUser = Auth::guard('admin')->user();
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
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">Users list</h3>
            @if (session('status'))
                <span class="alert alert-success float-right" role="alert">
                    {{ session('status') }}
                </span>
            @elseif (session('warning'))
                <span class="alert alert-danger float-right" role="alert">
                    {{ session('warning') }}
                </span>
            @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="users" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Member Since</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if($authUser->role->is('Master') || $authUser->role->is('Admin'))
                  @foreach($users as $user)
                    <tr>
                      <td>{{ $user['fname'].' '.$user['lname'] }}</td>
                      <td>{{ $user['username'] }}</td>
                      <td>{{ $user['email'] }}</td>
                      <form method="POST" action="{{ route('admin.user.update', ['id' => $user['id']]) }}">
                        @csrf
                        <td class="form-group">
                          @php
                            $roles = App\Models\Backend\User\Role::all();
                          @endphp
                          <select name="role_id" class="nice-select">
                            @foreach ($roles as $role)
                            <option value="{{$role->id}}"
                              @if($user->role->id == $role->id)
                                {{'selected'}}
                              @endif
                              @if ($role->is('Master'))
                                {{'disabled'}}
                              @endif >
                                {{$role->name}}
                             </option>
                            @endforeach
                          </select>
                        </td>
                        <td class="form-group">
                          @php
                            $statuses = App\Models\Backend\User\Status::all();
                          @endphp
                          <select name="status_id" class="nice-select" >
                            @foreach ($statuses as $status)
                            <option value="{{$status->id}}" @if($user->status->id == $status->id){{'selected'}}@endif>{{$status->name}}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>{{ date_format($user['created_at'], "d/m/Y") }}</td>
                        <td class="form-group">
                          <a class="btn btn-success" href="{{ route('admin.user.restore', ['id' => $user['id']]) }}" title="Restore user"><i class="fas fa-user-clock"></i></a>
                          <a class="btn btn-success" href="{{ route('admin.user.details', ['id' => $user['id']]) }}" title="User Details"><i class="fas fa-user-check"></i></a>
                          <a class="btn btn-danger" href="{{ route('admin.user.delete', ['id' => $user['id']]) }}" title="Delete User"><i class="fas fa-user-times"></i></a>
                        </td>
                      </form>
                    </tr>
                  @endforeach
                @else
                  @foreach($users as $user)
                    <tr>
                      <td>{{ $user['fname'].' '.$user['lname'] }}</td>
                      <td>{{ $user['username'] }}</td>
                      <td>{{ $user['email'] }}</td>
                      <td>
                        {{$user->role->name}}
                      </td>
                      <td>
                        {{$user->status->name}}
                        
                      </td>
                      <td>{{ date($user['created_at']) }}</td>
                      <td>
                        <a class="btn btn-info" href="{{ route('admin.edit-user', ['id' => $user['id']]) }}" title="Edit User"><i class="fas fa-user-edit"></i></a>
                        <a class="btn btn-success" href="{{ route('admin.user.details', ['id' => $user['id']]) }}" title="User Details"><i class="fas fa-user-check"></i></a>
                        <a class="btn btn-danger" href="{{ route('admin.remove.user', ['id' => $user['id']]) }}" title="Remove User"><i class="fas fa-user-times"></i></a>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Member Since</th>
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