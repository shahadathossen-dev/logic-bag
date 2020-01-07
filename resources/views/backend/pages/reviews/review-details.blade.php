
@php 
  $data['breadcrumb'] = [
    'Home' => route('admin.dashboard'),
    'Reviews' => route('admin.reviews'),
    'Review Details' => route('admin.reviews'),
  ];
  $data['title'] = 'Review Details';
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
                            <div id="review" class="" role="tabpanel" aria-labelledby="review-tab">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3 class="text-right">
                                            @if ($review->replies)
                                                {{count($review->replies)}}
                                            @else
                                                {{0}}
                                            @endif
                                            Replies
                                        </h3>
                                        <div class="review-pane">
                                            @if ($review)
                                            <div class="review row">
                                                <div class="col-md-2">
                                                    <img class="user-img" src="{{asset('storage/frontend/customers/'.$review->reviewer->avatar)}}"/>
                                                </div>
                                                <div class="col-md-10 no-gutters">
                                                    <div class="desc">
                                                        <h4>
                                                            <span class="text-left">
                                                                {{$review->reviewer->name}}
                                                                @if(!$review->isReviewed())
                                                                    <span class="label label-warning elevation-2 round-label">
                                                                        {{'Not reviewed'}}
                                                                    </span>
                                                                @elseif(!$review->isApproved())
                                                                    <span class="label label-danger elevation-2 round-label">
                                                                        {{'Denied'}}
                                                                    </span>
                                                                @else
                                                                    <span class="label label-success elevation-2 round-label">
                                                                        {{'Approved'}}
                                                                    </span>
                                                                @endif
                                                            </span>
                                                            <span class="minimize text-right" title="Minimize"><i class="far fa-window-minimize"></i></span>
                                                        </h4>
                                                        <p class="star">
                                                            <span class="rating_r rating_r_{{$review->rating}} banner_2_rating">
                                                                <i></i><i></i><i></i><i></i><i></i>
                                                            </span>
                                                            <span class="text-right">{{$review->created_at->format('d M Y H:i')}}</span>
                                                        </p>
                                                        <p>{{$review->comment}}</p>
                                                    </div>
                                                    <div class="edit-panel text-right">
                                                        <span class="edit" title="Edit">
                                                            <a class="" href="{{route('admin.review.status.update', ['id' => $review->id])}}" style="padding: 5px 10px;" title="Update review">
                                                            @if(!$review->isApproved())
                                                                <i class="fas fa-certificate"></i> Approve
                                                            @else
                                                                <i class="fas fa-ban"></i> Deny
                                                            @endif
                                                            </a>
                                                            <a class="" href="{{ route('admin.review.delete', ['id' => $review['id']]) }}" style="padding: 5px 10px;" title="Remove review"><i class="far fa-trash-alt"></i> Trash</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                @php
                                                    $replies = $review->allReplies;
                                                @endphp
                                                @if ($replies)
                                                <div class="col-md-10 offset-md-2 no-gutters">
                                                    <div class="reply-pane">
                                                        
                                                        @if (count($replies) > 0)
                                                        @foreach ($replies as $reply)
                                                        @php
                                                            $replier = $reply->replier;
                                                        @endphp
                                                        <div class="reply row">
                                                            <div class="col-md-2">
                                                                <div class="user-img">
                                                                    @if ($replier instanceof App\Model\Backend\User)
                                                                    <img class="user-img" src="{{asset('storage/backend/users/thumbnail/'.$replier->profile->avatar)}}"/>
                                                                    @else
                                                                    <img class="user-img" src="{{asset('storage/frontend/customers/'.$replier->avatar)}}"/>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10 pl-0">
                                                                <div class="desc">
                                                                    <h4>
                                                                        <span class="text-left">
                                                                        @if ($replier instanceof App\Model\Backend\User)
                                                                            {{$replier->name()}}
                                                                        @else
                                                                            {{$replier->name}}
                                                                        @endif
                                                                        @if(!$reply->isReviewed())
                                                                            <span class="badge badge-warning text-white">Not reviewed</span>
                                                                        @elseif(!$reply->isApproved())
                                                                            <span class="badge badge-danger text-white">Denied</span>
                                                                        @else
                                                                            <span class="badge badge-success text-white">Approved</span>
                                                                        @endif
                                                                        </span>
                                                                            
                                                                        <span class="text-right">{{$reply->created_at->format('d M Y H:i')}}</span>
                                                                    </h4>
                                                                    <p>{{$reply->comment}}</p>
                                                                </div>
                                                                <div class="edit-panel text-right">
                                                                    <span class="edit">
                                                                        <a class="" href="{{route('admin.reply.status.update', ['id' => $reply->id])}}" style="padding: 5px 10px;" title="Update reply">
                                                                        @if(!$reply->isApproved())
                                                                            <i class="fas fa-certificate"></i> Approve</a>
                                                                        @else
                                                                            <i class="fas fa-ban"></i> Deny</a>
                                                                        @endif
                                                                        @if ($user->id == $reply->user_id)
                                                                        <a class="edit-reply" data-target="#reply-form" style="padding: 5px 10px;" href="{{route('admin.reply.edit', ['id' => $reply->id])}}">
                                                                            <i class="fa fa-edit closed"></i><i class="far fa-file-alt open" style="display: none"></i> Edit
                                                                        </a>
                                                                        @endif
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
                                            {{-- {{ $reviews->links() }} --}}
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-md-push-1">
                                        <div class="rating-wrap">
                                            <h3 class="pane-title">Give a Reply</h3>
                                            <!-- Review Form -->
                                            <div id="reply-form">
                                                <form class="reply-form" method="POST" action="{{route('admin.reply.post')}}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <input type="hidden" name="review_id" value="{{$review->id}}">
                                                    <div class="form-group">
                                                        <textarea class="input form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" placeholder="Your reply" required></textarea>
                                                        @if ($errors->has('comment'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('comment') }}</strong>
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
