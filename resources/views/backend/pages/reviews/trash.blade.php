
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Reviews Trash' => route('admin.reviews.trash'),
        ];
    $data['title'] = 'Reviews Trash';
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
            <h3 class="card-title d-inline">Trashed reviews</h3>
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
            <table id="reviews" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Model</th>
                  <th>Rating</th>
                  <th>Comment</th>
                  <th>Replies</th>
                  <th>Deleted By</th>
                  <th>Deleted at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                
                @if(!count($trashed_reviews)==0)
                  @php
                    $sl = 1;
                  @endphp
                  @foreach($trashed_reviews as $review)
                    <tr>
                      <th>{{$sl}}</th>
                      <td>{{ $review->product->model }}</td>
                      <td>
                        <div class="rating_r
                            @if($review->rating == 1)
                                {{'rating_r_1'}}
                            @elseif($review->rating == 2)
                                {{'rating_r_2'}}
                            @elseif($review->rating == 3)
                                {{'rating_r_3'}}
                            @elseif($review->rating == 4)
                                {{'rating_r_4'}}
                            @elseif($review->rating == 5)
                              {{'rating_r_5'}}
                            @endif
                          banner_2_rating">
                            <i></i><i></i><i></i><i></i><i></i>
                          </div>
                      </td>
                      <td>{{ $review->comment }}</td>
                      <td>{{count($review->replies)}} Replies</td>
                      <td>
                        {{$review->updated_by}}
                      </td>
                      <td>{{ $review->deleted_at->format('d M Y H:i') }}</td>
                      <td>
                        <a class="btn btn-success" href="{{ route('admin.review.restore', ['id' => $review['id']]) }}" title="Restore review"><i class="fas fa-undo"></i></a>
                        <a class="btn btn-success" href="{{ route('admin.review.details', ['id' => $review['id']]) }}" title="Review details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger" href="{{ route('admin.review.destroy', ['id' => $review['id']]) }}" title="Destroy review"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="8" class="text-center">Review trash is empty.</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Sl No.</th>
                  <th>Model</th>
                  <th>Rating</th>
                  <th>Comment</th>
                  <th>Replies</th>
                  <th>Deleted By</th>
                  <th>Deleted at</th>
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