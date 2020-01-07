  
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
  <div class="p-3">
    <h5>Controlbar Menu</h5>
    @if (View::hasSection('controlbar-menu'))
     	@yield('controlbar-menu')
    @endif
  </div>
</aside>
<!-- /.control-sidebar -->
