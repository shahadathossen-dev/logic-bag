
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
                <div class="col-md-12">
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
                                    <div class="col-md-9">
                                        <h3 class="text-right">{{count($review->replies)}} Replies</h3>
                                        <div class="review-pane">
                                            @if ($review)
                                            <div class="review row">
                                                <div class="col-md-1">
                                                    <img class="user-img" src="{{asset('storage/frontend/customers/'.$review->reviewer->avatar)}}"/>
                                                </div>
                                                <div class="col-md-11 no-gutters">
                                                    <div class="desc">
                                                        <h4>
                                                            <span class="text-left">
                                                            {{$review->reviewer->name}}
                                                            </span>
                                                            <span class="minimize" title="Minimize"><i class="far fa-window-minimize"></i></span>

                                                        </h4>
                                                        <p class="star">
                                                            <span class="rating_r rating_r_{{$review->rating}} banner_2_rating">
                                                                <i></i><i></i><i></i><i></i><i></i>
                                                            </span>
                                                            <span class="text-right">{{$review->created_at->format('d M Y H:i')}}</span>
                                                        </p>
                                                        <p>{{$review->comment}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="pagination-links">
                                            {{-- {{ $reviews->links() }} --}}
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-md-push-1">
                                        <div class="rating-wrap">
                                            <h3 class="pane-title">Give a Reply</h3>
                                            <!-- Review Form -->
                                            <div id="reply-form">
                                                <form class="reply-form" method="POST" action="{{route('admin.reply.post')}}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <input type="hidden" name="review_id" value="{{$review->id}}">
                                                    <div class="form-group">
                                                        <textarea class="input form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" placeholder="Your Reply" required></textarea>
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
                                {{-- <div class="row">
                                    <div class="col-md-12 no-gutters">
                                        <table id="replies" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Sl.</th>
                                                    <th>Comment</th>
                                                    <th>Replier</th>
                                                    <th>Status</th>
                                                    <th>Created at</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            @if(!count($review->replies)==0)
                                              @php
                                                $sl = 1;
                                              @endphp
                                              @foreach($review->replies as $reply)
                                                <tr>
                                                  <th>{{$sl}}</th>
                                                  <td>{{ $reply->comment }}</td>
                                                  <td>
                                                    @if ($reply->replier instanceof App\Model\Backend\User)
                                                        {{'Admin'}}
                                                    @else 
                                                        {{'Customer'}}
                                                    @endif
                                                  </td>
                                                  <td>
                                                    <a class="btn
                                                    @if (!$reply->isApproved())
                                                      @if (!$reply->isReviewed())
                                                        bg-danger
                                                      @else
                                                        bg-warning
                                                      @endif
                                                    @else
                                                      bg-success
                                                    @endif"
                                                    href="{{route('admin.reply.update', ['id' => $reply->id])}}" style="padding: 5px 10px; border-radius: 40%; margin-left: 10px;" title="Update reply">
                                                    </a>
                                                  </td>
                                                  <td>{{ $reply->created_at->format('d M Y H:i') }}</td>
                                                  <td>
                                                    
                                                    <a class="btn btn-info edit-reply
                                                    @if (!$user->id == $reply->user_id)
                                                        {{'disabled'}}
                                                    @endif" data-target="#reply-form" href="{{ route('admin.reply.edit', ['id' => $reply['id']]) }}" title="Edit reply"><i class="far fa-edit"></i></a>
                                                    <a class="btn btn-success" href="{{ route('admin.reply.details', ['id' => $reply['id']]) }}" title="View reply"><i class="far fa-check-square"></i></a>
                                                    <a class="btn btn-danger" href="{{ route('admin.reply.delete', ['id' => $reply['id']]) }}" title="Remove reply"><i class="far fa-trash-alt"></i></a>
                                                  </td>
                                                </tr>
                                                @php
                                                  $sl++;
                                                @endphp
                                              @endforeach
                                            @else
                                                <tr class="empty">
                                                    <td colspan="4" class="text-center">Reply list is empty.</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Sl.</th>
                                                    <th>Comment</th>
                                                    <th>Replier</th>
                                                    <th>Status</th>
                                                    <th>Created at</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div> --}}
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
