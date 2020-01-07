@php
    $banners = App\Models\Frontend\Pages\Banner::all();
@endphp
<!-- Feature Big Add Area -->
<section id="feature-add">
    <div class="container-fluid text-center">
        <div class="row">
            @foreach ($banners as $banner)
            <div class="col-md-6">
                <div class="f_add_item white_add">
                    <div class="f_add_img">
                    	<img class="img-fluid" src="{{asset('/public/storage/backend/banners/original/'.$banner->banner)}}" alt="">
						<img class="img-fluid shadow" src="{{asset('resource/img/left_shadow.png')}}" alt="Webinar Map Shadow">
                    </div>
                    <div class="f_add_hover text-left">
                        <h4>Best Summer <br />Collection</h4>
                        <a class="add_btn" href="{{route('view.product', ['category' => str_slug($banner->item->category->title), 'subcategory' => str_slug($banner->item->subcategory->title), '$banner->item' => $banner->item->model, 'slug' => $banner->item->meta->slug, 'color' => str_slug($banner->item->attributeFirst()->color)])}}">Shop Now <i class="fa fa-arrow-right"></i></a>
                    </div>
                    @if($banner->item->hasDiscount())
                        <div class="off">{{($banner->item->discount->amount*100)}}% off</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Feature Big Add Area -->