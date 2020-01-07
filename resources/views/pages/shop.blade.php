
@php
	$categories = App\Models\Product\Category::all();
	$subcategories = App\Models\Product\Subcategory::all();

    $page['breadcrumb'] =   [
            'Home' => route('welcome'),
            'Shop' => route('shop'),
        ];
    $page['title'] = 'Shop';
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

<!-- Featured Product Area -->
<section id="shop" class="clear">
    <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 col-lg-9 order-sm-2 store">
                	
					<!-- Leather Tab -->
					@include('pages.partials.store')
					<!-- Leather Tab -->							

                </div>
                <div class="col-sm-4 col-lg-3 order-sm-1">
					<aside>
						@include('pages.partials.sidebar')
						
						<div class="sidebar">
							@include('layouts.modules.feature-slider')
						</div>
					</aside>
				</div>
            </div>
        </div>
    </div>
</section>
<!-- End Featured Product Area -->

@include('layouts.modules.trends')
@include('layouts.modules.characteristics')
@include('layouts.modules.newsletter')

<div id="quick-view">
</div>

@endsection