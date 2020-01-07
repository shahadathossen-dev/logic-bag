
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Discounts' => route('admin.products.discounts'),
        ];
    $data['title'] = 'Discounts List';
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
            <h3 class="card-title d-inline">Discounts list</h3>
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
            <table id="discounts" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Product Model</th>
                  <th>Discount <span class="float-right"></span></th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $sl = 1;
                @endphp
                @if(!count($discounts)==0)

                  @foreach($discounts as $discount)
                    <tr>
                      <td>{{$sl}}</td>
                      <td>{{ $discount->product['model'] }}</td>
                      <td>{{ ($discount['amount']*100)."%" }}</td>
                      <td>{{ $discount['created_at'] }}</td>
                      <td>
                        <a class="btn btn-info" href="{{ route('admin.discount.edit', ['id' => $discount['id']]) }}" title="Edit discount"><i class="far fa-edit"></i></a>
                        <a class="btn btn-success" href="{{ route('admin.discount.details', ['id' => $discount['id']]) }}" title="discount details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger" href="{{ route('admin.discount.delete', ['id' => $discount['id']]) }}" title="Remove discount"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="5" class="text-center">Tag list is empty.</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Sl No.</th>
                  <th>Title</th>
                  <th>Discount <span class="float-right"></span></th>
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