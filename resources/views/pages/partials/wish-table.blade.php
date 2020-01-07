
@if($wishes)

@if ($wishes->links())
    @section('pagination')
        {{ $wishes->links() }}
    @endsection
@endif

<div class="section-title">
    <h5>Your Wishlist Items</h5>
    <span class="pagination-links float-right">
        @if (View::hasSection('pagination'))
            @yield('pagination')
        @endif
    </span>
</div>
<div class="wish-room">
    <table class="table table-striped table-responsive wish-table animated slideInDown wow" data-wow-duration="1s" data-wow-delay=".5s">
        <colgroup>
            <col class="item-thumbnail"></col>
            <col class="item-title"></col>
            <col class="item-price" ></col>
            <col class="item-action"></col>
        </colgroup>
        <thead>
            <tr class="text-center">
                <th>Product</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wishes as $wish)
            @php
                $product = $wish->product;
                $attribute = $product->attribute($wish->attribute);
            @endphp
            <tr class="wish-item">
                <td class="wish_product_img">
                    <div class="wish-item-img" title="Quick-view">
                        <a class="quick-view" data-toggle="modal" href="{{route('view.product', ['category' => strtolower($product->category->title), 'subcategory' => str_slug(strtolower($product->subcategory->title)), 'product' => $product->model, 'slug' => $product->meta->slug, 'color' => str_slug($attribute->color)])}}">
                            <img class="img-fluid" src="{{asset('/public/storage/backend/products/'.$product->model.'/'.$attribute->sku.'/thumbnail/'.$product->attribute($attribute->sku)->images[0])}}" alt="{{$product->attribute($attribute->sku)->images[0].' image'}}" alt="Product">
                        </a>
                    </div>
                </td>
                <td class="cart_product_desc">
                    <a href="{{route('view.product', ['category' => strtolower($product->category->title), 'subcategory' => str_slug(strtolower($product->subcategory->title)), 'product' => $product->model, 'slug' => $product->meta->slug, 'color' => str_slug($attribute->color)])}}" title="View product" class="view-details">
                        <h5>{{$product->title}}</h5>
                    </a>
                </td>
                <td class="text-right price">
                    <span>{{number_format($product->absolutePrice(), 2)}}/-</span>
                </td>
                <td class="action text-center">
                   <a class="btn btn-warning compare-btn" href="{{route('compare.item.add', ['model' => $product->model])}}">
                        <i class="fas fa-chart-pie"></i>
                    </a>
                   <a class="btn btn-success cart-btn" href="{{route('cart.item.add', ['product' => $product->model, 'sku' => $attribute->sku, 'color' => str_slug($attribute->color)])}}">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                   <a class="btn btn-danger remove-item" href="{{route('wish.item.remove', ['model' => $product, 'attribute' => $attribute, 'color' => str_slug($attribute->color)])}}" title="Remove Item"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <a href="{{route('shop')}}" class="btn btn-dark text-uppercase">continue shopping</a>
                </td>
                <td>
                </td>
                <td class="text-center">
                    <a href="{{route('user.cart')}}" class="btn btn-dark text-uppercase">View cart</a>
                </td>
            </tr>
            
        </tfoot>
    </table>
</div>

@endif
