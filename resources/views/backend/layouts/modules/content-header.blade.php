<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            @if($data){{ $data['title'] }}@endif
          </h1>
        </div><!-- /.col -->
        @php
          $lastValue = end($data['breadcrumb']);
          $lastKey = key($data['breadcrumb']);
        @endphp
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
                
            @foreach($data['breadcrumb'] as $title => $route)
              @if ($lastKey === $title)
                <li class="breadcrumb-item active">{{$title}}</li>
              @else
                <li class="breadcrumb-item">
                  <a href="{{ $route }}">
                    {{ $title}}
                  </a>
                </li>
              @endif
            @endforeach
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content-header -->