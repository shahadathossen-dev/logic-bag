
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Products' => route('admin.products'),
        ];
    $data['title'] = 'Products List';
@endphp

@extends('backend.layouts.default')

@section('page_title')
{{ $data['title'] }}
@endsection

@section('content')

@include('backend.layouts.modules.navbar')
@include('backend.layouts.modules.sidebar')
@include('backend.layouts.modules.content-header')

  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">Tags list</h3>
            @if (session('status'))
                <span class="alert alert-success" role="alert">
                    {{ session('status') }}
                </span>
            @elseif (session('warning'))
                <span class="alert alert-danger" role="alert">
                    {{ session('warning') }}
                </span>
            @endif
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="float-right">
              {{-- {{ $products->links() }} --}}
            </div>
            <table id="products" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Model</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Price</th>
                  <th>Tags</th>
                  <th>Colors</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!count($products)==0)
                  @foreach($products as $product)
                    <tr>
                      <td>{{ $product['title'] }}</td>
                      {{-- <td>{{ implode(' x ', explode(',', $product->dimension)) }}</td> --}}
                      <td>{{ $product['model'] }}</td>
                      <td>{{ $product->category->title }}</td>
                      <td>{{ $product->subcategory->title }}</td>
                      <td>{{ 'BDT '.number_format((float)$product->price, 2, '.', '') }}</td>
                      <td>
                        @foreach($product->tags as $tag)
                          <span class="label label-info elevation-2 round-label mb-2">{{$tag->name}}</span>
                        @endforeach
                      </td>
                      <td>
                        @foreach($product->attributes as $attribute)
                          <a class="elevation-2 round-label text-white mb-2" href="{{ route('admin.product.attribute.details', ['attribute' => $attribute]) }}" title="product details" style="background-color:{{$attribute->meta_color}};">{{$attribute->color}}</a>
                        @endforeach
                      </td>
                      <td>
                        <a class="btn btn-info btn-tool elevation-2 mb-2" href="{{ route('admin.product.edit', ['id' => $product['id']]) }}" title="Edit product"><i class="far fa-edit"></i></a>
                        <a class="btn btn-success btn-tool elevation-2 mb-2" href="{{ route('admin.product.details', ['id' => $product['id']]) }}" title="product details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger delete btn-tool elevation-2 mb-2" href="{{ route('admin.product.delete', ['id' => $product['id']]) }}" data-title="{{ $product['title'] }}" title="Archive product"><i class="fas fa-archive"></i></a>
                      </td>
                    </tr>
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="8" class="text-center">Product list is empty.</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Title</th>
                  <th>Tags</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Dimension</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
    
</div>
<!-- /.content-wrapper -->

@include('backend.layouts.modules.controlbar')

</section>
@endsection