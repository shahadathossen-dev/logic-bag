
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Orders' => route('admin.orders'),
        ];
    $data['title'] = 'Orders List';
    $sl = 1;
    $statuses = App\Models\Orders\Status::all();
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
            <h3 class="card-title d-inline">Tags list</h3>
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
            <div class="float-right">
              {{-- {{ $orders->links() }} --}}
            </div>
            <table id="orders" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Order Number</th>
                  <th>Payment Mode</th>
                  <th>Delivery Date</th>
                  <th>Invoice</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!count($orders)==0)
                  @foreach($orders as $order)
                    <tr>
                      <td>{{ $sl }}</td>
                      <td>{{ $order['order_number'] }}</td>
                      <td>{{ $order['payment_mode'] }}</td>
                      <td>{{ date($order->delivery_date) }}</td>
                      <td>{{ $order->status_id }}</td>
                      <td>
                        <form action="{{route('admin.order.update')}}" method="POST" class="update-Order">
                          @csrf
                          <input type="hidden" name="order" value="{{$order->id}}">
                          <div class="input-group">
                              <select name="status" class="nice-select form-control">
                                  @foreach($statuses as $status)
                                  <option value="{{$status->id}}" @if($order->status_id == $status->id) {{'selected'}} @endif>{{$status['name']}}</option>
                                  @endforeach
                              </select>
                              <div class="input-group-append">
                                <button class="btn bg-success update-order" title="Update Order" type="update">Update</button>
                              </div>
                          </div>
                        </form>
                      </td>
                      <td><a href="{{route('admin.order.invoice.show', ['invoice' => $order->invoice->invoice_number])}}" title="View invoice">{{ $order->invoice['invoice_number'] }}</a></td>
                      <td>
                        <a class="btn btn-info btn-tool elevation-2 mb-2" href="{{ route('admin.order.edit', ['id' => $order['id']]) }}" title="Edit order"><i class="far fa-edit"></i></a>
                        <a class="btn btn-success btn-tool elevation-2 mb-2" href="{{ route('admin.order.details', ['id' => $order['id']]) }}" title="order details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger delete btn-tool elevation-2 mb-2" href="{{ route('admin.order.delete', ['id' => $order['id']]) }}" data-title="{{ $order['title'] }}" title="Remove order"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="8" class="text-center">Product list is empty.</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Title</th>
                  <th>Tags</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Dimension</th>
                  <th>Price</th>
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