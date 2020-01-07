
@php
    $unreadCount = Auth::guard('admin')->user()->unreadNotifications->count();

    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Notifications' => route('admin.notifications'),
        ];

    $data['title'] = 'User Notifications';
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
      <div class="col-8">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">Notifications</h3>
            @if (session('status'))
                <span class="alert alert-success text-right" role="alert">
                    {{ session('status') }}
                </span>
            @elseif (session('warning'))
                <span class="alert alert-danger text-right" role="alert">
                    {{ session('warning') }}
                </span>
            @endif
            <span class="notifications-batch float-right @if(count($notifications) < 1){{'isDisabled'}}@endif">
              <a class="notification-action markallasread btn-tool @if($unreadCount < 1){{'isDisabled'}}@endif" href="{{route('admin.notifications.markallasread')}}" title="Mark all as read"><i class="fas fa-check-double"></i> Mark all as read</a> | 
              <a class="notification-action deleteall btn-tool" href="{{route('admin.notifications.deleteall')}}" title="Delete All"><i class="far fa-trash-alt"></i> Delete All</a>
            </span>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="notifications" class="table text-center">
              <colgroup>
                <col></col>
                <col></col>
                <col></col>
                <col></col>
              </colgroup>
              <thead>
                <tr>
                  <th class="text-left">Notification Title</th>
                  <th>Time</th>
                  <th>Read at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="notification-list">
                @if($notifications)
                  @foreach($notifications as $notification)
                  @php
                    $notificationTitle = rtrim(str_replace('_', ' ', snake_case(class_basename($notification->type))), 'notification');
                  @endphp
                    <tr class="notification-item">
                      <td class=" text-left">
                        <a class="read-notification {{$notification->id}} @if(!is_null($notification['read_at'])){{'read text-muted'}}@endif" href="{{$notification->data[0]}}" data-target="{{route('admin.notification.markasread', ['id' => $notification->id])}}">
                          <i class="fa fa-user-plus"></i> {{ucfirst($notificationTitle)}}
                        </a>
                      </td>
                      <td>
                        <span class="text-muted text-sm since-time">
                          {{ calcDiff($period = date_diff($notification['created_at'], now())) }}
                          ago
                        </span>
                      </td>
                      <td class="read_at text-muted" style="font-style: italic;">
                        @if(!is_null($notification['read_at']))
                          {{$notification->read_at->format('d M y, H:i:s')}}
                        @else
                          {{'Not read yet'}}
                        @endif
                      </td>
                      <td class="btn-container single-notification-action">
                        <a role="button" class="btn btn-success btn-tool markasread" href="{{route('admin.notification.markasread', ['id' => $notification->id])}}" data-id="{{$notification->id}}" data-category="{{'#'.snake_case($notificationTitle)}}" title="Mark as read" style="@if(!is_null($notification['read_at'])){{'display: none;'}}@endif"><i class="far fa-envelope-open"></i></a>
                        <a role="button" class="btn btn-primary btn-tool markasunread" href="{{route('admin.notification.markasunread', ['id' => $notification->id])}}" data-id="{{$notification->id}}" data-category="{{'#'.snake_case($notificationTitle)}}" data-type="{{$notification->type}}" title="Mark as unread" style="@if(is_null($notification['read_at'])){{'display: none;'}}@endif"><i class="far fa-envelope"></i></a>
                        <a role="button" class="btn btn-danger btn-tool delete-notification" href="{{route('admin.notification.delete', ['id' => $notification->id])}}" data-id="{{$notification->id}}" data-category="{{'#'.snake_case($notificationTitle)}}" data-type="{{$notification->type}}" title="Delete item"><i class="far fa-times-circle"></i></a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="4">You have no notification.</td>
                  </tr>
                @endif
                
              </tbody>
              <tfoot>
                <tr>
                  
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