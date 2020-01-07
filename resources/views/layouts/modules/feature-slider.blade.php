@php
    $featuredItems = App\Models\Product::published()->whereHas('order_item')->withCount('order_item')  // Count the orders
                                    ->orderBy('order_item_count', 'desc')   // Order by the order_item count
                                    ->orderBy('created_at', 'desc')   // Order by the order_time count
                                    ->take(15)    // Take the first 5
                                    ->get()->chunk(5);
    if (count($featuredItems) < 4) {
        $featuredItems = App\Models\Product::published()->withCount('order_item')  // Count the orders
                                    ->orderBy('order_item_count', 'desc')   // Order by the order_item count
                                    ->orderBy('created_at', 'desc')   // Order by the order_time count
                                    ->join('metas', 'products.model', '=', 'metas.model')->orderBy('metas.views', 'desc')
                                    ->take(15)     // Take the first 5
                                    ->get()->chunk(5);
    }
@endphp
<div class="f_product_left">
    <div class="section-title">
        <h5>Featured Products</h5>
    </div>
    <div class="f_product_inner owl-carousel">
        @foreach($featuredItems as $products_chunk)
		<div class="featured-slider-item">
            @foreach($products_chunk as $product)
            <div class="media">
                <div class="d-flex">
                    <img class="img-feature" src="{{asset('/public/storage/backend/products/'.$product->model.'/'.$product->attributeFirst()->sku.'/thumbnail/'.$product->attributeFirst()->images[0])}}" alt="Not Found">
                </div>
                <div class="media-body">
                    <h4>{{$product->title}}</h4>
                    <h6>BDT {{number_format($product->price, 2)}}</h6>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>