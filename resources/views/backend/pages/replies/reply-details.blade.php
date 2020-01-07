
@php 
  $data['breadcrumb'] = [
    'Home' => route('admin.dashboard'),
    'Replies' => route('admin.replies'),
    'Reply Details' => route('admin.reply.details', ['id' => $reply->id]),
  ];
  $data['title'] = 'Reply Details';
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
                            <div class="reply" class="">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table id="product" class="table table-bordered table-striped mb-3">
                                            <thead>
                                                <tr>
                                                    <th class="text-right" width="30%">Property</th>
                                                    <th width="80%">Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th class="text-right">{{ 'Product Title' }}</th>
                                                    <td>{{ $reply->review->product->title }}</td>
                                                </tr>

                                                <tr>
                                                    <th class="text-right">{{ 'Product Model' }}</th>
                                                    <td>{{ $reply->review->product->model }}</td>
                                                </tr>

                                                <tr>
                                                    <th class="text-right">{{ 'Review comment' }}</th>
                                                    <td>{{ $reply->review->comment }}</td>
                                                </tr>

                                                <tr>
                                                    <th class="text-right">{{ 'Review rating' }}</th>
                                                    <td>
                                                        <div class="rating_r
                                                            @if($reply->review->rating == 1)
                                                                {{'rating_r_1'}}
                                                            @elseif($reply->review->rating == 2)
                                                                {{'rating_r_2'}}
                                                            @elseif($reply->review->rating == 3)
                                                                {{'rating_r_3'}}
                                                            @elseif($reply->review->rating == 4)
                                                                {{'rating_r_4'}}
                                                            @elseif($reply->review->rating == 5)
                                                              {{'rating_r_5'}}
                                                            @endif
                                                          banner_2_rating">
                                                            <i></i><i></i><i></i><i></i><i></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-right">{{ 'Reply Comment' }}</th>
                                                    <td>{{ $reply->comment }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-right">{{ 'Replier' }}</th>
                                                    <td>
                                                    @if ($reply->replier instanceof App\Model\Backend\User)
                                                        {{'Admin'}}
                                                    @else 
                                                        {{'Customer'}}
                                                    @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="text-right">{{ 'Status' }}</th>
                                                    <td>
                                                    @if(!$reply->isReviewed())
                                                        <label class="label label-danger elevation-2 round-label">
                                                            {{'Not Reviewd'}}
                                                        </label>
                                                    @elseif(!$reply->isApproved())
                                                        <label class="label label-warning elevation-2 round-label">
                                                        {{'Not Approved'}}
                                                        </label>
                                                    @else 
                                                        <label class="label label-success elevation-2 round-label">
                                                        {{'Approved'}}
                                                        </label>
                                                    @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">{{'Action'}}</td>
                                                    <td class="text-left">
                                                        @if(!$reply->isApproved())
                                                        <a class="btn btn-success" href="{{route('admin.reply.status.update', ['id' => $reply->id])}}" style="padding: 5px 10px;" title="Update reply">
                                                            <i class="fas fa-certificate"></i> Approve
                                                        </a>
                                                        @else
                                                        <a class="btn btn-danger" href="{{route('admin.reply.status.update', ['id' => $reply->id])}}" style="padding: 5px 10px;" title="Update reply">
                                                            <i class="fas fa-ban"></i> Deny
                                                        </a>
                                                        @endif
                                                        @if ($user->id == $reply->user_id)
                                                        <a class="btn btn-primary edit-reply" data-target="#reply-form" style="padding: 5px 10px;" href="{{route('admin.reply.edit', ['id' => $reply->id])}}">
                                                            <i class="fa fa-edit closed"></i><i class="far fa-file-alt open" style="display: none"></i> Edit
                                                        </a>
                                                        @endif
                                                        <a class="btn btn-secondary" href="{{ route('admin.reply.delete', ['id' => $reply['id']]) }}" style="padding: 5px 10px;" title="Remove reply"><i class="far fa-trash-alt"></i> Trash</a>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4 col-md-push-1">
                                        <div class="rating-wrap">
                                            <h3 class="pane-title">Give a Reply</h3>
                                            <!-- Review Form -->
                                            <div id="reply-form">
                                                <form class="reply-form" method="POST" action="{{route('admin.reply.update')}}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <input type="hidden" name="review_id" value="{{$reply->review->id}}">
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
