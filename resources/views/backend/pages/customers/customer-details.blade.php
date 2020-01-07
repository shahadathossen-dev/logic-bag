@php
  $data = ['Home', 'Users', 'User Details'];
@endphp

@extends('backend.layouts.default')

@section('page_title')
{{ end($data) }}
@endsection

@section('content')

@include('backend.layouts.modules.navbar')
@include('backend.layouts.modules.sidebar')
@include('backend.layouts.modules.content-header')

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/backend/users/thumbnail/'.$user->profile['avatar'])}}" alt="{{$user['fname']}}'s profile picture">
              </div>

              <h3 class="profile-username text-center">{{$user['fname'].' '.$user['lname']}}</h3>

              <p class="text-muted text-center">
                {{$user->role->name}}
              </p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Username</b> <span class="float-right">{{$user['username']}}</span>
                </li>
                <li class="list-group-item">
                  <b>Birthday</b> <span class="float-right">{{date('jS F, Y', strtotime($user->profile['dob']))}}</span>
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <span class="float-right">{{$user->profile['phone']}}</span>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <span class="float-right">{{$user['email']}}</span>
                </li>
                <li class="list-group-item">
                  <b>Since</b> <span class="float-right">{{date('jS F, Y', strtotime($user['created_at']))}}</span>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
          </div>
        </div>
        <!-- /.card -->
        <div class="col-md-9">
          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title float-left">About {{$user['fname']}}</h3>
              <div class="float-right">
                @if($user->isPending())
                  <a class="btn btn-info" href="{{ route('admin.approve.user',["id" => $user->id]) }}" title="Edit User"><i class="fas fa-user-edit"></i> Approve Profile</a>
                @endif
              </div>
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <strong><i class="fa fa-book mr-1"></i> Education</strong>

              <p class="text-muted">
                {{$user->profile['education']}}
              </p>

              <hr>

              <strong><i class="fa fa-map-marker mr-1"></i> Location</strong>

              <p class="text-muted">
                {{$user->profile['address']}}
              </p>

              <hr>

              <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

              <p class="text-muted">
                {{$user->profile['skills']}}
              </p>

              <hr>

              <strong><i class="fas fa-file-alt mr-1"></i> Notes</strong>

              <p class="text-muted">
                {{$user->profile['notes']}}
              </p>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              @if (session('status'))
                <div class="col">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
              @elseif (session('warning'))
                <div class="col">
                    <div class="alert alert-danger" role="alert">
                        {{ session('warning') }}
                    </div>
                </div>
              @endif
              </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
    
</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

</section>
@endsection