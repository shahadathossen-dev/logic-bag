
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Products Trash' => route('admin.products.trash'),
        ];
    $data['title'] = 'Products Trash';
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
            <table id="tags" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Title</th>
                  <th>Tags</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Price</th>
                  <th>Deleted at</th>
                  <th>Deleted by</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $sl = 1;
                @endphp
                @if(!count($trashed_products)==0)

                  @foreach($trashed_products as $trashed_product)
                    <tr>
                      <td>{{$sl}}</td>
                      <td>{{ $trashed_product['title'] }}</td>
                      <td>
                        @foreach($trashed_product->tags as $tag)
                          <span class="badge badge-info elevation-2">{{$tag->name}}</span>
                        @endforeach
                      </td>
                      <td>{{ $trashed_product->category->title }}</td>
                      <td>{{ $trashed_product->subcategory->title }}</td>
                      <td>{{ 'BDT '.number_format((float)$trashed_product->price, 2, '.', '') }}</td>
                      <td>{{ $trashed_product->deleted_at }}</td>
                      <td>{{ $trashed_product->updated_by }}</td>
                      <td>
                        <a class="btn btn-success" href="{{ route('admin.product.restore', ['id' => $trashed_product['id']]) }}" title="Edit product"><i class="fas fa-undo"></i></a>
                        <a class="btn btn-info" href="{{ route('admin.product.details', ['id' => $trashed_product['id']]) }}" title="product details"><i class="far fa-check-square"></i></a>
                        <a class="btn btn-danger destroy" href="{{ route('admin.product.destroy', ['id' => $trashed_product['id']]) }}" title="Remove product"><i class="far fa-trash-alt"></i></a>
                      </td>
                    </tr>
                    @php
                      $sl++;
                    @endphp
                  @endforeach
                @else
                  <tr class="empty">
                    <td colspan="9" class="text-center">Product list is empty.</td>
                  </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Sl No.</th>
                  <th>Title</th>
                  <th>Tags</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Price</th>
                  <th>Deleted at</th>
                  <th>Deleted by</th>
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