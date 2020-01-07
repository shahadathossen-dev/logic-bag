<div class="header-wrapicon2">
    <img src="{{ asset('resource/img/icons/icon-header-02.png') }}" class="header-icon1 js-show-header-dropdown" alt="ICON">
    @php
        $cart = session('cart');
        $items = 0;
    @endphp
    @if ($cart)
        @php
            foreach ($cart as $model => $productModel){
                foreach ($productModel as $sku => $item) {
                    $items += $item->quantity;
                }
            }
        @endphp
    @endif
    <span class="header-icons-noti">{{$items}}</span>

    <!-- Header cart noti -->
    <div class="header-cart header-dropdown">
        @php $total = 0; @endphp

        <ul class="header-cart-wrapitem @if(!$cart){{'d-none'}}@endif">
            @if($cart)
                @foreach($cart as $model => $productModel)
                @foreach($productModel as $sku => $item)
                    <li class="header-cart-item cart-item" data-item="{{$item->attribute['sku']}}">
                        <div class="header-cart-item-img">
                            <a class="remove" title="Remove Item" href="{{route('cart.item.remove', ['model' => $item->model, 'sku' => $item->attribute['sku']])}}" title="Remove Item">
                                <img class="img-fluid" src="{{asset('/public/storage/backend/products/'.$item->model.'/'.$item->attribute['sku'].'/thumbnail/'.$item->attribute['images'][0])}}" alt="IMG">
                            </a>
                        </div>

                        <div class="header-cart-item-txt">
                            <a href="#" class="header-cart-item-name">
                                {{$item->title}}
                            </a>

                            <span class="header-cart-item-info">
                                {{$item->quantity}} &times; {{number_format($item->price, 2)}}
                            </span>
                            
                            <span class="badge cart-badge float-right" style="background-color:{{strtolower($item->attribute['color'])}};">{{$item->attribute['color']}}</span>

                            {{-- <a class="remove float-right" href="{{route('cart.remove', ['model' => $item->model, 'sku' => $item->sku])}}" title="Remove Item">
                                <i class="fa fa-trash"></i>
                            </a> --}}

                        </div>
                    </li>
                    @php $total += ($item->quantity * $item->price); @endphp
                @endforeach
                @endforeach
            @endif
        </ul>

        <div class="header-cart-total w-100 @if(!$cart){{'d-none'}}@endif">
            {{-- <span class="items text-left">Item(s): {{$items}}</span> --}}
            Total: <span class="subtotal">{{number_format($total, 2)}}</span> BDT
        </div>

        <div class="header-cart-buttons text-center @if(!$cart){{'d-none'}}@endif">
            <div class="header-cart-wrapbtn">
                <!-- Button -->
                <a href="{{route('user.cart')}}" class="btn btn-warning">
                    View Cart
                </a>
            </div>
            
            <div class="header-cart-wrapbtn text-center">
                <!-- Button -->
                <a href="{{route('order.checkout')}}" class="btn btn-success">
                    Check Out
                </a>
            </div>
        </div>
       
        <span class="btn-warning round-label empty-cart  @if($cart){{'d-none'}}@endif">Cart Empty!</span>
        
    </div>
</div>