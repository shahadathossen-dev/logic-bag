
@if($orders)

@if ($orders->links())
    @section('pagination')
        {{ $orders->links() }}
    @endsection
@endif

<div class="section-title">
    <h5>Your Orders History</h5>
    <span class="pagination-links float-right">
        @if (View::hasSection('pagination'))
            @yield('pagination')
        @endif
    </span>
</div>
<div class="order-room">
    <table class="table table-striped table-responsive order-table animated slideInDown wow" data-wow-duration="1s" data-wow-delay=".5s">
        <thead>
            <tr class="text-center">
                <th>Sl No.</th>
                <th>Order Number</th>
                <th>Bill</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr class="order-item">
                <th>{{ $sl }}</th>
                <td class="order_number">
                    {{$order->order_number}}
                </td>
                <td class="text-right bill">
                    <span>{{number_format($order->invoice->bill, 2)}}/-</span>
                </td>
                <td>{{ date('d-m-Y', strtotime($order->delivery_date)) }}</td>
                <td>{{$order->created_at->format('d-m-Y')}}</td>
                <td class="text-right status">
                    <span>{{$order->status->name}}</span>
                </td>
                <td class="action text-center">
                   <a class="btn btn-success" href="{{route('user.order.view', ['order' => $order])}}" title="Check Order">
                        <i class="far fa-check-square"></i>
                    </a>
                   <a class="btn btn-danger remove-item {{$order->isCancellable() ? '' : 'disabled'}}" href="{{route('user.order.cancel', ['order' => $order])}}" title="Cancel Order"><i class="far fa-trash-alt"></i></a>
                </td>
            </tr>
            @php
                $sl++;
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <a href="{{route('shop')}}" class="btn btn-dark text-uppercase">continue shopping</a>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center" colspan="2">
                    <a href="{{route('user.cart')}}" class="btn btn-dark text-uppercase">View cart</a>
                </td>
            </tr>
            
        </tfoot>
    </table>
</div>

@endif
