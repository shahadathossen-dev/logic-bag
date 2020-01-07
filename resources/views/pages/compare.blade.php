
@php
    $page['breadcrumb'] =   [
            'Home' => route('welcome'),
            'Compare Table' => route('user.compare.table'),
        ];
    $page['title'] = 'Compare Table';
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
@if($compare)
<!--================Product Compare Area =================-->
<section id="product-compare" class="bg-light">
    <div class="container-fluid">
    	<div class="row justify-content-sm-center">
    		<div class="compare-table">
    			<div class="section-title">
            		<h5>Your Compare Table</h5>
            	</div>
                <table class="table table-responsive table-striped">
                    <colgroup>
                        <col class="property">
                        @foreach ($compare as $model => $product)
                        <col class="{{$product->model}}">
                        @endforeach
                    </colgroup>
                    <thead>
                        <tr>
                            <td scope="col"></td>
                            @php $column = 2; @endphp
                            @foreach ($compare as $model => $product)
                            <td scope="col">
                                <a class="btn bg-danger remove-item" href="{{route('compare.item.remove', ['model' => $product->model])}}" data-column="{{$column}}" title="Remove item">&cross; Remove Item</a>
                            </td>
                            @php $column++; @endphp
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            @foreach ($compare as $model => $product)
                            <th scope="col">
                            	{{$product->title}}
	                            <div class="rating_r
								@if (is_float($product->ratingAverage()))
									@if ($product->ratingAverage() > 1 && $product->ratingAverage() < 2)
										{{'rating_r_1_plus'}}
									@elseif ($product->ratingAverage() > 2 && $product->ratingAverage() < 3)
										{{'rating_r_2_plus'}}
									@elseif ($product->ratingAverage() > 3 && $product->ratingAverage() < 4)
										{{'rating_r_3_plus'}}
									@elseif ($product->ratingAverage() > 4 && $product->ratingAverage() < 5)
										{{'rating_r_4_plus'}}
									@endif
								@else
						            @if($product->ratingAverage() == 1)
						                {{'rating_r_1'}}
						            @elseif($product->ratingAverage() == 2)
						                {{'rating_r_2'}}
						            @elseif($product->ratingAverage() == 3)
						                {{'rating_r_3'}}
						            @elseif($product->ratingAverage() == 4)
						                {{'rating_r_4'}}
						            @elseif($product->ratingAverage() == 5)
						              {{'rating_r_5'}}
						            @endif
								@endif
								banner_2_rating">
									<i></i><i></i><i></i><i></i><i></i>									
								</div>
							</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>                       
                        <tr>
                            <th scope="row"><span>Summary</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                                <img class="img-fluid" src="{{asset('/public/storage/backend/products/'.$product->model.'/'.$product->attributeFirst()->sku.'/medium/'.$product->attributeFirst()->images[0])}}" alt="{{$product->attributeFirst()->images[0].' image'}}" alt="">
                                <ul>
                                    <li>
                                    	<a class="btn btn-success cart-btn" href="{{route('cart.item.add', ['model' => $product->model, 'sku' => $product->attributeFirst()->sku])}}"><i class="fa fa-shopping-cart"></i> Add Cart</a>
                                    </li>
                                    <li class="p_icon">
                                    	<button class="btn btn-primary wish-btn" type="button"><i class="fa fa-heart"></i> Wishlist</button>
                                    </li>
                                </ul>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Model</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                                <h6>{{$product->model}}</h6>
                            </td>
                            @endforeach
                        </tr>

                        <tr>
                            <th scope="row"><span>Price</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                                <h3>BDT {{number_format($product->absolutePrice(), 2)}}</h3>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Dimension</span></th>
                            @foreach ($compare as $model => $product)
                            <td><h6>{{str_replace(',', ' x ', $product->dimension)}}</h6></td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Chamber</span></th>
                            @foreach ($compare as $model => $product)
                            <td><h6>{{$product->chamber}}</h6></td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Weight</span></th>
                            @foreach ($compare as $model => $product)
                            <td><h6>{{$product->weight}}</h6></td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Color</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                            	<h6>
                            		@foreach ($product->attributes as $attribute)
                            		<a class="elevation-2 round-label text-white" href="{{route('view.product', ['category' => str_slug($product->category->title), 'subcategory' => str_slug($product->subcategory->title), 'model' => $product->model, 'slug' => str_slug($product->meta->slug), 'color' => str_slug($attribute->color)])}}" title="product details" style="background-color:{{strtolower($attribute->color)}};">
                            			{{$attribute->color}}
                            		</a>&nbsp;
                           			@endforeach
                        		</h6>
                        	</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Brand</span></th>
                            @foreach ($compare as $model => $product)
                            <td><h6>Logic</h6></td>
                            @endforeach
                        </tr>
                        {{-- <tr>
                            <th scope="row"><span>Extendable</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                            	@if ($product->property->extendable)
                            	<h6>Yes</h6>
                            	@else
                            	<h6>No</h6>
                            	@endif
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Fabrics</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                            	<h6>{{$product->property->fabrics}}</h6>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Material</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                            	<h6>{{$product->property->material}}</h6>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Inner Fabrics</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                            	<h6>{{$product->property->inner_fabrics}}</h6>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Runner</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                            	<h6>{{$product->property->runner}}</h6>
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row"><span>Zipper</span></th>
                            @foreach ($compare as $model => $product)
                            <td>
                            	<h6>{{$product->property->zipper}}</h6>
                            </td>
                            @endforeach
                        </tr> --}}
                    </tbody>
                    <tfoot>
                    	<tr>
                    		<td colspan="4">
                				<a class="btn btn-secondary continue text-uppercase float-right" href="{{route('shop')}}">continue shopping</a>
                    		</td>
                    	</tr>
                    </tfoot>
                </table>
            </div>
    	</div>
    </div>
</section>
<!--================End Product Compare Area =================-->
@endif
@include('layouts.modules.recent')
@include('layouts.modules.characteristics')
@include('layouts.modules.newsletter')

@endsection