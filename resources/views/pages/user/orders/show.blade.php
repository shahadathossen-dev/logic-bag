
@php 
    $page['breadcrumb'] = [
            'Home' => route('admin.dashboard'),
            'Order History' => route('user.order.history'),
            'Order Details' => route('user.order.view', ['order' => $order->order_number]),
        ];
    $page['title'] = 'Order Details';
@endphp
@extends('layouts.default')

@section('page_subtitle')
    {{$page['title']}}
@endsection

@section('meta_description')
We are introducing “Logic Manufacturing Co.” is one of the leading Bag & different IT related accessories manufacturers in Bangladesh. Logic Manufacturing Co. realizes that in order to achieve our mission and long-term goals, we must meet the needs of our valued customers and provide a safe and secure work environment for our working family. Logic is totally committed to being a company whose integrity and quality for service is unsurpassed in the bag & different IT related accessories industry. As a leading innovator in the design of computer carrying cases and travel bags, our mission is to provide travelers with more than just stylish and reliable bags. We strive for excellence and are passionate in our efforts to continue to shape and define the market for traveling bags. We aspire to be the best, focusing on the needs of travelers and producing solutions that meet their standards.
@endsection

@section('content')
@include('layouts.modules.preloader')
@include('layouts.modules.breadcrumb')

<section id="order">
    <!-- Order details table Area -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title">
                    <h5>Order Details</h5>
                </div>
                <div class="order-table-area row">
                    @if ($order)
                    <div class="order col-md-6">
                        <table id="order" class="table table-bordered mb-3">
                            <tbody>
                                <tr><th>{{ 'Order Number' }}</th><td class="text-right">{{ $order->order_number }}</td></tr>
                                <tr><th>{{ 'Invoice Number' }}</th><td class="text-right">{{ $order->invoice->invoice_number }}</td></tr>
                                <tr><th>{{ 'Order Date' }}</th><td class="text-right">{{ $order->created_at->format('d-m-Y') }}</td></tr>
                                <tr><th>{{ 'Delivery Date' }}</th><td class="text-right">{{ Illuminate\Support\Carbon::parse($order->delivery_date)->format('d-m-Y') }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="invoice col-md-6">
                        <table id="order" class="table table-bordered mb-3">
                            @php
                                $sl = $price = $subTotal = $deliveryFee = 0;
                            @endphp
                            @foreach ($order->items as $item)
                            @php
                                $price = ($item->quantity * $item->price);
                                $deliveryFee += ($item->quantity * 100);
                                $subTotal += $price;
                                $sl += 1;
                            @endphp
                            @endforeach
                            @php
                                $tax = ($subTotal * 0.05);
                                $shipping = 100;
                                $grandTotal = $subTotal + $tax + $shipping;
                                $due = $grandTotal - $order->invoice->payment;
                            @endphp
                            <tr>
                                <th>Subtotal</th>
                                <th>{{number_format($subTotal, 2)}}</th>
                            </tr>
                            <tr>
                                <th>{{'Tax (0.5%)'}}</th>
                                <th>{{number_format($tax, 2)}}</th>
                            </tr>
                            <tr>
                                <th>{{'Delivery Fee'}}</th>
                                <th>{{number_format(100, 2)}}</th>
                            </tr>
                            <tr>
                                <th>{{'Grand Total'}}</th>
                                <th>{{number_format($grandTotal, 2)}}</th>
                            </tr>
                        </table>
                    </div>
                    @endif
                </div>
                <div class="section-title">
                    <h5>Order items</h5>
                </div>
                <table class="table table-bordered table-striped mb-3">
                    <colgroup>
                        <col class="serial">
                        <col class="title">
                        <col class="model">
                        <col class="color">
                        <col class="quantity">
                        <col class="rate">
                        <col class="subtotal">
                    </colgroup>
                    <thead>
                        <tr>
                            <th width="5%">Sl.</th>
                            <th width="35%">Item</th>
                            <th width="10%">Model</th>
                            <th width="10%">Color</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Unit Rate</th>
                            <th width="10%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = $price = $subTotal = $deliveryFee = 0;
                        @endphp
                        @foreach ($order->items as $item)
                        @php
                            $price = ($item->quantity * $item->price);
                            $deliveryFee += ($item->quantity * 100);
                            $subTotal += $price;
                            $sl += 1;
                        @endphp
                        <tr>
                            <td>{{sprintf('%02d', $sl)}}</td>
                            <td style="text-align: left;">{{$item->product->title}}</td>
                            <td>{{$item->model}}</td>
                            <td>{{$item->variant->color}}</td>
                            <td>{{$item->quantity}}</td>
                            <td style="text-align: right;">{{number_format($item->price, 2)}}</td>
                            <td style="text-align: right; font-weight: bold;">{{number_format($price, 2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>                 
                </table>
            </div>
            <div class="col-lg-4">
                @include('layouts.modules.feature-slider')
            </div>
        </div>
    </div>
    <!-- End Order details table Area -->
</section>

@include('layouts.modules.recent')
@include('layouts.modules.characteristics')
@include('layouts.modules.newsletter')

<div id="quick-view">
</div>

@endsection
