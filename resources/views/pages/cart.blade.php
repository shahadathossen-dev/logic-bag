
@php
    $page['breadcrumb'] =   [
            'Home' => route('welcome'),
            'Shopping Cart' => route('user.cart'),
        ];
    $page['title'] = 'User Cart';
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
@if($cart)
<!-- Featured Product Area -->
<section id="cart">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-table-area">
                    <div class="section-title">
                        <h5>Your Cart Items</h5>
                    </div>
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
                    <div class="cart-room">
                        <table id="cart-table" class="table table-striped table-responsive text-center wow animated slideInDown" style="overflow-x: visible;" data-wow-duration="1s" data-wow-delay=".5s">
                            <colgroup>
                                <col class="item-thumbnail"></col>
                                <col class="item-title"></col>
                                <col class="item-color" ></col>
                                <col class="item-quantity"></col>
                                <col class="item-price" ></col>
                                <col class="item-total"></col>
                                <col class="item-action"></col>
                            </colgroup>
                            <thead>
                                <tr class="">
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subTotal = 0;
                                    $deliveryFee = 0;
                                @endphp
                                @foreach($cart as $model => $productModel)
                                @foreach($productModel as $sku => $item)
                                <tr class="cart-item" data-item="{{$item->attribute['sku']}}">
                                <form action="{{route('update.cart.item')}}" method="POST" class="update-cart-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item->model.'.'.$item->attribute['sku']}}">
                                    <td class="cart_product_img">
                                        <div class="cart-image" title="Remove item">
                                            <a class="remove" title="Remove Item" href="{{route('cart.item.remove', ['model' => $item->model, 'sku' => $item->attribute['sku']])}}" title="Remove Item">
                                                <img class="img-fluid" src="{{asset('/public/storage/backend/products/'.$item->model.'/'.$item->attribute['sku'].'/thumbnail/'.$item->attribute['images'][0])}}" alt="{{$item->attribute['images'][0].' image'}}">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="cart_product_desc">
                                        {{$item->title}}
                                    </td>
                                    <td class="cart_product_desc">
                                        <div class="form-group">
                                            <select name="sku" class="nice-select">
                                                @foreach($item->attributes as $attribute)
                                                <option value="{{$attribute['sku']}}" @if($item->attribute['sku'] == $attribute['sku']) {{'selected'}} @endif>{{$attribute['color']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td class="text-center qty">
                                        <div class="form-group">
                                            <div class="qty-btn d-flex float-right input-group">
                                                <div class="quantity">
                                                    <span class="qty-minus"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                                    <input type="number" class="qty qty-text" id="" step="1" min="1" name="quantity" value="{{$item->quantity}}">
                                                    <span class="qty-plus"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right price">
                                        <span>{{number_format($item->price, 2)}}</span>
                                    </td>
                                    <td class="text-right total">
                                        <span>{{number_format($item->price*$item->quantity, 2)}}</span>
                                    </td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <button class="btn bg-success update-cart" title="Update Item" type="submit"></button>
                                            <a class="btn btn-warning remove" title="Remove Item" href="{{route('cart.item.remove', ['model' => $item->model, 'sku' => $item->attribute['sku']])}}" title="Remove Item">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </form>
                                </tr>
                                @php
                                    $subTotal += ($item->quantity * $item->price);
                                    $deliveryFee += ($item->quantity * 100);
                                @endphp
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-left">
                                        <a href="{{route('shop')}}" class="btn btn-secondary text-uppercase">continue shopping</a>
                                    </td>
                                    <td colspan="2">     
                                        <input class="d-inline" type="text" placeholder="Apply cuopon">
                                        <i class="fas fa-gift"></i>
                                    </td>
                                    <td colspan="3" class="text-right">
                                        <a href="#" class="btn btn-dark text-uppercase">update cart</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary">
                    <div class="section-title">
                        <h5>Cart Total</h5>
                    </div>
                    <table class="table table-striped">
                        <colgroup>
                            <col class="title"></col>
                            <col class="amount"></col>
                        </colgroup>
                        <thead>
                            
                        </thead>
                        <tbody>
                            <tr>
                                <th>Subtotal</th>
                                <td class="subtotal text-right">{{number_format($subTotal, 2)}}</td>
                            </tr>

                            <tr>
                                <th>Delivery</th>
                                <td class="delivery-fee text-right">
                                    @if ($deliveryFee > 0)
                                        {{number_format($deliveryFee, 2)}}
                                    @else
                                        {{'Free'}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="total text-right" style="font-weight: bold;">{{number_format(($subTotal + $deliveryFee), 2)}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-center">
                                    <a href="{{route('order.checkout')}}" class="btn btn-success text-uppercase">Proceed To Checkout</a>
                                </th>
                            </tr>
                            
                        </tfoot>
                    </table>
                </div>
                <div class="calculate_shoping_area">
                    <div class="section-title">
                        <h5>Calculate Shoping</h5>
                    </div>
                    <!-- <h5 class="cart_single_title">Calculate Shoping</h5> -->
                    <div class="calculate_shop_inner">
                        <form class="calculate_shoping_form row" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                            <div class="form-group col-lg-12">
                                <select class="nice-select" name="district">
                                    <option>United State America (USA)</option>
                                    <option>United State America (USA)</option>
                                    <option>United State America (USA)</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" class="form-control" id="state" name="state" placeholder="State / Country">
                            </div>
                            <div class="form-group col-lg-6">
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="Postcode / Zip">
                            </div>
                            
                            <div class="collapse" id="shipping-recognition">
                                <div class="card card-body">
                                    <p>
                                        There are no shipping methods available. Please double check your address, or contact us if you need any help. 
                                    </p>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <button  type="submit" value="submit" onclick="myFunction(event); function myFunction(e) { e.preventDefault(); }" class="btn btn-info form-control text-uppercase" data-toggle="collapse" data-target="#shipping-recognition" aria-expanded="false" aria-controls="collapseExample">
                                    update totals
                                </button>
                                <!-- <button type="submit" value="submit" class="btn submit_btn form-control text-uppercase">update totals</button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Featured Product Area -->
@endif
@include('layouts.modules.recent')
@include('layouts.modules.characteristics')
@include('layouts.modules.newsletter')

@endsection