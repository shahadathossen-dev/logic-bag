
@php 
  $data['breadcrumb'] = [
    'Home' => route('admin.dashboard'),
    'Messages' => route('admin.messages'),
    'Message Details' => route('admin.messages'),
  ];

  $data['title'] = 'Message Details';
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{ end($data) }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus-circle"></i></button>
                                <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times-circle"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (session('status'))
                                <div class="col-md-6 offset-md-4">
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @elseif (session('warning'))
                                <div class="col-md-6 offset-md-4">
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('warning') }}
                                    </div>
                                </div>
                            @endif
                            <div id="message" class="" role="tabpanel" aria-labelledby="message-tab">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="text-right">
                                            @if ($message->replies)
                                                {{$message->replies_count}}
                                            @else
                                                {{0}}
                                            @endif
                                            Replies
                                        </h3>
                                        <div class="message-pane">
                                            @if ($message)
                                            <div class="message row">
                                                <div class="col-md-2">
                                                    <img class="user-img" src="{{asset('/public/storage/frontend/customers/'.$message->user->avatar)}}"/>
                                                </div>
                                                <div class="col-md-10 no-gutters">
                                                    <div class="desc">
                                                        <h4>
                                                            <span class="text-left">
                                                                {{-- <span>{{$message->user->name}}</span> --}}
                                                                {{$message->user->name}}
                                                                @if(!$message->isReviewed())
                                                                    <span class="label label-warning elevation-2 round-label">
                                                                        {{'Not reviewed'}}
                                                                    </span>
                                                                @else
                                                                    <span class="label label-success elevation-2 round-label">
                                                                        {{'Reviewed'}}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                            <span class="minimize text-right" title="Minimize"><i class="far fa-window-minimize"></i></span>
                                                        </h4>
                                                        <p class="about">
                                                            <span class="subject">
                                                                {{$message->subject}}
                                                            </span>
                                                            <span class="text-right">{{$message->created_at->format('d M Y H:i')}}</span>
                                                        </p>
                                                        <p>{{$message->message}}</p>
                                                    </div>
                                                </div>
                                                @php
                                                    $replies = $message->replies()->paginate(5);
                                                @endphp
                                                @if ($replies)
                                                <div class="col-md-10 offset-md-2 no-gutters">
                                                    <div class="reply-pane">
                                                        
                                                        @if ($message->replies_count > 0)
                                                        @foreach ($replies as $reply)
                                                        @php
                                                            $replier = $reply->replier;
                                                        @endphp
                                                        <div class="reply row">
                                                            <div class="col-md-2">
                                                                <div class="user-img">
                                                                    <img class="user-img" src="{{asset('/public/storage/backend/users/thumbnail/'.$replier->profile->avatar)}}"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10 pl-0">
                                                                <div class="desc">
                                                                    <h4>
                                                                        <span class="text-left">
                                                                            {{$replier->name()}}
                                                                        </span>
                                                                            
                                                                        <span class="text-right">{{$reply->created_at->format('d M Y H:i')}}</span>
                                                                    </h4>
                                                                    <p>{{$reply->reply}}</p>
                                                                </div>
                                                                <div class="action-panel text-right">
                                                                    <span class="action">
                                                                        <a class="trash" href="{{ route('admin.reply.delete', ['id' => $reply['id']]) }}" style="padding: 5px 10px;" title="Remove reply"><i class="far fa-trash-alt"></i> Trash</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        <div class="pagination-links">
                                            {{ $replies->links() }}
                                        </div>                                        
                                    </div>
                                    <div class="col-md-4 col-md-push-1">
                                        <div class="rating-wrap">
                                            <h3 class="pane-title">Give a Reply</h3>
                                            <!-- Review Form -->
                                            <div id="reply-form">
                                                <form class="reply-form" method="POST" action="{{route('admin.message.reply.post')}}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <input type="hidden" name="message_id" value="{{$message->ticket}}">
                                                    <div class="form-group">
                                                        <input class="input form-control {{ $errors->has('subject') ? 'is-invalid' : '' }}" type="text" name="subject" value="{{ 'RE: "'.$message->subject.'", Ref: #'.$message->ticket }}" readonly>
                                                        @if ($errors->has('subject'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('subject') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea class="input form-control {{ $errors->has('reply') ? 'is-invalid' : '' }}" name="reply" placeholder="Type your message" required></textarea>
                                                        @if ($errors->has('reply'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('reply') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                </form>
                                            </div>
                                            <!-- /Review Form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

@endsection
