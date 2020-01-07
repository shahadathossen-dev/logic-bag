
@php 
  $data['breadcrumb'] = [
    'Home' => route('admin.dashboard'),
    'Messages' => route('admin.messages'),
  ];
  $data['title'] = 'Messages List';
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
            <h3 class="card-title d-inline">Messages list</h3>
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
            <table id="messages" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Customer</th>
                  <th>Replies</th>
                  <th>Status</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                
                @if(!count($messages)==0)
                  @php
                    $sl = 1;
                  @endphp
                  @foreach($messages as $message)
                    <tr>
                      <th>{{$sl}}</th>
                      <td>{{ $message->subject }}</td>
                      <td>{{ $message->message }}</td>
                      <td>{{ $message->user->name }}</td>
                      <td>{{$message->replies_count}} Replies</td>
                      <td>
                        <a class="btn
                          @if (!$message->isReviewed())
                            bg-danger
                          @else
                            bg-success
                          @endif"
                        href="{{route('admin.message.status.update', ['id' => $message->id])}}" style="padding: 5px 10px; border-radius: 40%; margin-left: 10px;" title="Update message">
                        </a>
                      </td>
                      <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                      <td>
                        <a class="btn btn-success" href="{{ route('admin.message.details', ['id' => $message['id']]) }}" title="message details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger" href="{{ route('admin.message.destroy', ['id' => $message['id']]) }}" title="Remove role"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="9" class="text-center">Message list is empty.</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Sl No.</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Customer</th>
                  <th>Replies</th>
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