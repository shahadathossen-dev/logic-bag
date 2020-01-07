
@php 
  $panel = 1;
  $authUser = Auth::guard('admin')->user();
  $unreadCount = $authUser->unreadNotifications->count();
  $notificationGroup = $authUser->unreadNotifications->groupBy('type')->sortByDesc('created_at');
@endphp

<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-board" data-accordion="false">

  <li class="dropdown-header notification-header">
    <span class="notification-count">
      {{$unreadCount}}
    </span>
    Unread Notification(s)
  </li>

  @foreach($notificationGroup as $notificationType => $unreadNotificationsByType)
    @php
      $notificationTitle = rtrim(str_replace('_', ' ', snake_case(class_basename($notificationType))), 'notification');
    @endphp
    <li class="dropdown-item text-center" id="{{snake_case($notificationTitle)}}">
      <a class="notification-category collapsed" data-toggle="collapse" href="#{{snake_case($notificationTitle).$panel}}" data-parent="#notification-board" data-target="#{{snake_case($notificationTitle).$panel}}" aria-expanded="false" aria-controls="{{snake_case($notificationTitle).$panel}}">
        <i class="fa fa-users mr-2"></i>
        <span class="notification-count">
          {{$unreadNotificationsByType->count()}}
        </span>
        {{ucfirst($notificationTitle)}}
      </a>
      <ul class="notification-list collapse" id="{{snake_case($notificationTitle).$panel}}" aria-labelledby="{{snake_case($notificationTitle)}}" data-parent="#notification-board">
        @foreach($unreadNotificationsByType as $notification)
          <li class="notification-item">
            <a class="read-notification {{$notification->id}}" href="{{$notification->data[0]}}" data-target="{{route('admin.notification.markasread', ['id' => $notification->id])}}">
              <i class="fa fa-user-plus"></i> {{ucfirst($notificationTitle)}}
            </a>
            <span class="float-right text-muted text-sm single-notification-action">
              <span class="time-count">
                {{ calcDiff($period = date_diff($notification['created_at'], now())) }}
              </span>
              <span class="btn-container" style="display: none;">
                <a role="button" class="btn btn-tool markasread" href="{{route('admin.notification.markasread', ['id' => $notification->id])}}" data-id="{{$notification->id}}" data-category="{{'#'.snake_case($notificationTitle)}}" title="Mark as read" style="padding: 0;"><i class="far fa-envelope-open"></i></a>
                <a role="button" class="btn btn-tool markasunread" href="{{route('admin.notification.markasunread', ['id' => $notification->id])}}" data-id="{{$notification->id}}" data-category="{{'#'.snake_case($notificationTitle)}}" data-type="{{$notificationType}}" title="Mark as unread" style="padding: 0; display: none;"><i class="far fa-envelope"></i></a>
                <a role="button" class="btn btn-tool delete-notification" href="{{route('admin.notification.delete', ['id' => $notification->id])}}" data-id="{{$notification->id}}" data-category="{{'#'.snake_case($notificationTitle)}}" data-type="{{$notificationType}}" title="Delete item" style="padding: 0;"><i class="far fa-times-circle"></i></a>
              </span>
            </span>
          </li>
        @endforeach
      </ul>
    </li>
    @php $panel++; @endphp
  @endforeach
  <li href="#" class="dropdown-footer notification-footer justify-content-around text-center">
    <span class="col">
      <a class="notification-action" href="{{route('admin.notifications')}}">See all notifications</a>
    </span>|
    <span class="col @if($unreadCount < 1){{'isDisabled'}}@endif">
      <a class="notification-action markallasread" href="{{route('admin.notifications.markallasread')}}">Mark all as read</a>
      <a class="notification-action deleteall" href="{{route('admin.notifications.deleteall')}}" style="display: none;">Delete All</a>
    </span>
  </li>
</ul>

@php
  function calcDiff($period){
      if ($period->format("%h") < 1){
        return $period->format("%i mins %s s");
      }elseif ($period->format("%d") < 1){
        return $period->format("%h hrs %i mins");
      }elseif ($period->format("%m") < 1){
        return $period->format("%d day(s)");
      }elseif ($period->format("%y") < 1){
        return $period->format("%m months");
      }else {
        return $period->format("%y year(s)");
      }
  }
@endphp