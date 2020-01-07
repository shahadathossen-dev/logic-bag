
@php 
    $data['breadcrumb'] =   [
            'Home' => route('admin.dashboard'),
            'Trade Marks' => route('admin.page.trade-marks'),
        ];
    $data['title'] = 'Trade Marks';
@endphp

@extends('backend.layouts.default')

@section('page_title')
{{ end($data) }}
@endsection

@section('content')

@include('backend.layouts.modules.navbar')
@include('backend.layouts.modules.sidebar')
@include('backend.layouts.modules.content-header')

  <section class="content">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title d-inline">Home Page contents</h3>
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
            <ul>
              <li>
                <a href="{{route('admin.page.trade-marks.logo.create')}}" id="edit" class="" type="button" title="Add Page Content"><i class="fab fa-slack"></i> Add Logo</a>
              </li>
              <li>
                <a href="{{route('admin.page.trade-marks.logo.edit')}}" id="edit" class="" type="button" title="Update Page Content"><i class="fab fa-slack"></i> Update Logo</a>
              </li>
              <li>
                <a href="{{route('admin.page.trade-marks.type.create', ['trade' => 'email'])}}" id="edit" class="" type="button" title="Add Page Content"><i class="fas fa-at"></i> Add Email</a>
              </li>
              <li>
                <a href="{{route('admin.page.trade-marks.type.edit', ['trade' => 'email'])}}" id="edit" class="" type="button" title="Update Page Content"><i class="fas fa-at"></i> Update Email</a>
              </li>
              <li>
                <a href="{{route('admin.page.trade-marks.type.create', ['trade' => 'phone'])}}" id="edit" class="" type="button" title="Add Page Content"><i class="fas fa-phone-volume"></i> Add Phone</a>
              </li>
              <li>
                <a href="{{route('admin.page.trade-marks.type.edit', ['trade' => 'phone'])}}" id="edit" class="" type="button" title="Update Page Content"><i class="fas fa-phone-volume"></i> Update Phone</a>
              </li>
              <li>
                <a href="{{route('admin.page.trade-marks.type.create', ['trade' => 'facebook'])}}" id="edit" class="" type="button" title="Add Page Content"><i class="fab fa-facebook-square"></i> Add Facebook Link</a>
              </li>
              <li>
                <a href="{{route('admin.page.trade-marks.type.edit', ['trade' => 'facebook'])}}" id="edit" class="" type="button" title="Update Page Content"><i class="fab fa-facebook-square"></i> Update Facebook Link</a>
              </li>
            </ul>
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