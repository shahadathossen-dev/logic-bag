@php
    $categories = App\Models\Product\Category::all();
    $subcategories = App\Models\Product\Subcategory::all();
@endphp
@include('layouts.modules.meta')

@yield('content')

@include('layouts..modules.footer')