
@php 
  $data['breadcrumb'] = [
    'Home' => route('admin.dashboard'),
    'Replies' => route('admin.reviews'),
  ];
  $data['title'] = 'Replies List';
  $user = Auth::guard('admin')->user();
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
            <h3 class="card-title d-inline">Replies list</h3>
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
            <table id="replies" class="table table-bordered table-striped">
              <thead>
                  <tr>
                      <th>Sl.</th>
                      <th>Model</th>
                      <th>Review ID</th>
                      <th>Comment</th>
                      <th>Replier</th>
                      <th>Status</th>
                      <th>Created at</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
              
              @if(!count($replies)==0)
                @php
                  $sl = 1;
                @endphp
                @foreach($replies as $reply)
                  <tr>
                    <th>{{$sl}}</th>
                    <td>{{ $reply->review()->withTrashed()->first()->product->model }}</td>
                    <td>{{ $reply->review_id }}</td>
                    <td>{{ $reply->comment }}</td>
                    <td>
                      @if ($reply->replier instanceof App\Model\Backend\User)
                          {{'Admin'}}
                      @else 
                          {{'Customer'}}
                      @endif
                    </td>
                    <td>
                      @if(!$reply->isReviewed())
                          <label class="label label-danger elevation-2 round-label">
                              {{'Not Reviewd'}}
                          </label>
                      @elseif(!$reply->isApproved())
                          <label class="label label-warning elevation-2 round-label">
                          {{'Denied'}}
                          </label>
                      @else 
                          <label class="label label-success elevation-2 round-label">
                          {{'Approved'}}
                          </label>
                      @endif
                    </td>
                    <td>{{ $reply->created_at->format('d M Y H:i') }}</td>
                    <td>
                      @if(!$reply->isApproved())
                        <a class="btn btn-success" href="{{route('admin.reply.status.update', ['id' => $reply->id])}}" style="padding: 5px 10px;" title="Update reply">
                            <i class="fas fa-certificate"></i>
                        </a>
                      @else
                        <a class="btn btn-warning" href="{{route('admin.reply.status.update', ['id' => $reply->id])}}" style="padding: 5px 10px;" title="Update reply">
                            <i class="fas fa-ban"></i>
                        </a>
                      @endif
                      <a class="btn btn-primary" href="{{ route('admin.reply.details', ['id' => $reply['id']]) }}" title="View reply"><i class="far fa-check-square"></i></a>
                      <a class="btn btn-danger" href="{{ route('admin.reply.delete', ['id' => $reply['id']]) }}" title="Remove reply"><i class="far fa-trash-alt"></i></a>
                    </td>
                  </tr>
                  @php
                    $sl++;
                  @endphp
                @endforeach
              @else
                  <tr class="empty">
                      <td colspan="8" class="text-center">Reply list is empty.</td>
                  </tr>
              @endif
              </tbody>
              <tfoot>
                  <tr>
                      <th>Sl.</th>
                      <th>Model</th>
                      <th>Review ID</th>
                      <th>Comment</th>
                      <th>Replier</th>
                      <th>Status</th>
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