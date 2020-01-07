
@php
  $authUser = Auth::guard('admin')->user();
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{asset('backend/img/logicbag-logo.jpg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name')}}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="float-left image">
        <img src="{{asset('/public/storage/backend/users/thumbnail/'.$authUser->profile['avatar'])}}" class="img-circle" alt="User Image">
      </div>
      <div class="float-left info">
        <p>{{ $authUser->fname .' '. $authUser->lname}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-sidebar class="panel-group" id="sidebar-menu" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        @if ($authUser->role->is("Master") || $authUser->role->is('Admin'))
          <li class="nav-item card">
            <div class="card-header" id="users-wizard">
              <a class="nav-link {{(Request::is('backend/user*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#usersPanel" data-parent="#sidebar-menu" data-target="#usersPanel" aria-expanded="true" aria-controls="usersPanel">
                <i class="nav-icon fa fa-users-cog"></i>
                <p>
                  Users
                </p>
              </a>
            </div>

            <div id="usersPanel" class="collapse {{(Request::is('backend/user*') ? 'show' : '')}}" aria-labelledby="users-wizard" data-parent="#sidebar-menu">
              <div class="card-body">
                <div class="sub-category">
                  <ul class="nav">
                    <li class="nav-item {{(Request::is('backend/user/create') ? 'active' : '')}}">
                      <a href="{{ route('admin.user.create') }}" class="nav-link">
                        <i class="fa fa-user-plus nav-icon"></i>
                        <p>Create User</p>
                      </a>
                    </li>
                    <li class="nav-item {{(Request::is('backend/users') ? 'active' : '')}}">
                      <a href="{{ route('admin.users') }}" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Users List</p>
                      </a>
                    </li>
                    <li class="nav-item {{(Request::is('backend/users/trash') ? 'active' : '')}}">
                      <a href="{{ route('admin.users.trash') }}" class="nav-link">
                        <i class="fas fa-user-times nav-icon"></i>
                        <p>Users Trash</p>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>

          <li class="nav-item card">
            <div class="card-header" id="roles-wizard">
              <a class="nav-link {{(Request::is('backend/role*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#rolesPanel" data-parent="#sidebar-menu" data-target="#rolesPanel" aria-expanded="true" aria-controls="rolesPanel">
                <i class="nav-icon far fa-id-badge"></i>
                <p>
                  Roles
                </p>
              </a>
            </div>

            <div id="rolesPanel" class="collapse {{(Request::is('backend/role*') ? 'show' : '')}}" aria-labelledby="roles-wizard" data-parent="#sidebar-menu">
              <div class="card-body">
                <div class="sub-category">
                  <ul class="nav">
                    <li class="nav-item {{(Request::is('backend/roles/create') ? 'active' : '')}}">
                      <a href="{{ route('admin.role.create') }}" class="nav-link">
                        <i class="fas fa-plus-circle nav-icon"></i>
                        <p>Create Role</p>
                      </a>
                    </li>
                    <li class="nav-item {{(Request::is('backend/roles') ? 'active' : '')}}">
                      <a href="{{ route('admin.roles') }}" class="nav-link">
                        <i class="fas fa-list nav-icon"></i>
                        <p>Roles List</p>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>

          <li class="nav-item card">
            <div class="card-header" id="status-wizard">
              <a class="nav-link {{(Request::is('backend/status*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#statusPanel" data-parent="#sidebar-menu" data-target="#statusPanel" aria-expanded="true" aria-controls="statusPanel">
                <i class="nav-icon fa fa-award"></i>
                <p>
                  Status
                </p>
              </a>
            </div>

            <div id="statusPanel" class="collapse {{(Request::is('backend/status*') ? 'show' : '')}}" aria-labelledby="status-wizard" data-parent="#sidebar-menu">
              <div class="card-body">
                <div class="sub-category">
                  <ul class="nav">
                    <li class="nav-item {{(Request::is('backend/status/add') ? 'active' : '')}}">
                      <a href="{{ route('admin.status.create') }}" class="nav-link">
                        <i class="fa fa-plus-circle nav-icon"></i>
                        <p>Create Status</p>
                      </a>
                    </li>
                    <li class="nav-item {{(Request::is('backend/statuses') ? 'active' : '')}}">
                      <a href="{{ route('admin.statuses') }}" class="nav-link">
                        <i class="fas fa-list nav-icon"></i>
                        <p>Status List</p>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
        @endif

        <li class="nav-item card">
          <div class="card-header" id="category-wizard">
            <a class="nav-link {{(Request::is('backend/categor*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#categories-panel" data-parent="#sidebar-menu" data-target="#categories-panel" aria-expanded="true" aria-controls="categories-panel">
              <i class="fas fa-sitemap nav-icon"></i>
              <p>
                Categories
              </p>
            </a>
          </div>

          <div id="categories-panel" class="collapse {{(Request::is('backend/categor*') ? 'show' : '')}}" aria-labelledby="category-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/categories/add') ? 'active' : '')}}">
                  <a href="{{route('admin.category.add')}}" class="nav-link">
                    <i class="fas fa-plus-circle nav-icon"></i>
                    <p>Add new category</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/categories') ? 'active' : '')}}">
                  <a href="{{route('admin.categories')}}" class="nav-link">
                    <i class="fas fa-sitemap nav-icon"></i>
                    <p>Categories list</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="subcategory-wizard">
            <a class="nav-link {{(Request::is('backend/subcategor*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#subcategories-panel" data-parent="#sidebar-menu" data-target="#subcategories-panel" aria-expanded="true" aria-controls="subcategories-panel">
              <i class="fas fa-project-diagram nav-icon"></i>
              <p>
                Subcategories
              </p>
            </a>
          </div>

          <div id="subcategories-panel" class="collapse {{(Request::is('backend/subcategor*') ? 'show' : '')}}" aria-labelledby="category-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/subcategories/add') ? 'active' : '')}}">
                  <a href="{{route('admin.subcategory.add')}}" class="nav-link">
                    <i class="fas fa-plus-circle nav-icon"></i>
                    <p>Add new Subcategory</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/subcategories') ? 'active' : '')}}">
                  <a href="{{route('admin.subcategories')}}" class="nav-link">
                    <i class="fas fa-sitemap nav-icon"></i>
                    <p>Subcategories list</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="tags-wizard">
            <a class="nav-link {{(Request::is('backend/tag*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#tags-panel" data-parent="#sidebar-menu" data-target="#tags-panel" aria-expanded="true" aria-controls="tags-panel">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Tags
              </p>
            </a>
          </div>

          <div id="tags-panel" class="collapse {{(Request::is('backend/tag*') ? 'show' : '')}}" aria-labelledby="tags-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/tag/add') ? 'active' : '')}}">
                  <a href="{{route('admin.tag.add')}}" class="nav-link">
                    <i class="fas fa-tag nav-icon"></i>
                    <p>Add new Tag</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/tags') ? 'active' : '')}}">
                  <a href="{{route('admin.tags')}}" class="nav-link">
                    <i class="fas fa-tags nav-icon"></i>
                    <p>Tags list</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="labels-wizard">
            <a class="nav-link {{(Request::is('backend/feature*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#features-panel" data-parent="#sidebar-menu" data-target="#features-panel" aria-expanded="true" aria-controls="features-panel">
              <i class="nav-icon fas fa-tag"></i>
              <p>
                Features
              </p>
            </a>
          </div>

          <div id="features-panel" class="collapse {{(Request::is('backend/feature*') ? 'show' : '')}}" aria-labelledby="labels-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/feature/add') ? 'active' : '')}}">
                  <a href="{{route('admin.feature.add')}}" class="nav-link">
                    <i class="far fa-plus-square nav-icon"></i>
                    <p>Add new Feature</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/features') ? 'active' : '')}}">
                  <a href="{{route('admin.features')}}" class="nav-link">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Features list</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="discount-wizard">
            <a class="nav-link {{(Request::is('backend/products/discount*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#discount-panel" data-parent="#sidebar-menu" data-target="#discount-panel" aria-expanded="true" aria-controls="discount-panel">
              <i class="nav-icon fas fa-percentage"></i>
              <p>
                Discounts
              </p>
            </a>
          </div>

          <div id="discount-panel" class="collapse {{(Request::is('backend/products/discount*') ? 'show' : '')}}" aria-labelledby="discount-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/products/discount/add') ? 'active' : '')}}">
                  <a href="{{route('admin.products.discount.add')}}" class="nav-link">
                    <i class="far fa-plus-square nav-icon"></i>
                    <p>Add batch discount</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/products/discounts') ? 'active' : '')}}">
                  <a href="{{route('admin.products.discounts')}}" class="nav-link">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Discounts list</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>
        
        <li class="nav-item card">
          <div class="card-header" id="tags-wizard">
            <a class="nav-link {{(Request::is('backend/banner*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#banners-panel" data-parent="#sidebar-menu" data-target="#banners-panel" aria-expanded="true" aria-controls="banners-panel">
              <i class="nav-icon fa fa-image"></i>
              <p>
                Banners
              </p>
            </a>
          </div>

          <div id="banners-panel" class="collapse {{(Request::is('backend/banner*') ? 'show' : '')}}" aria-labelledby="banners-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/banner/add') ? 'active' : '')}}">
                  <a href="{{route('admin.banner.add')}}" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Add new Banner</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/banners') ? 'active' : '')}}">
                  <a href="{{route('admin.banners')}}" class="nav-link">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Banners list</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="tags-wizard">
            <a class="nav-link {{(Request::is('backend/page*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#pages-panel" data-parent="#sidebar-menu" data-target="#pages-panel" aria-expanded="true" aria-controls="pages-panel">
              <i class="nav-icon fa fa-image"></i>
              <p>
                Pages
              </p>
            </a>
          </div>

          <div id="pages-panel" class="collapse {{(Request::is('backend/page*') ? 'show' : '')}}" aria-labelledby="pages-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/page/about-us') ? 'active' : '')}}">
                  <a href="{{route('admin.page.about-us')}}" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>About Us</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/page/trade-marks*') ? 'active' : '')}}">
                  <a href="{{route('admin.page.trade-marks')}}" class="nav-link">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Trade Marks</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="tags-wizard">
            <a class="nav-link {{(Request::is('backend/slider*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#sliders-panel" data-parent="#sidebar-menu" data-target="#sliders-panel" aria-expanded="true" aria-controls="sliders-panel">
              <i class="nav-icon fa fa-image"></i>
              <p>
                Home Sliders
              </p>
            </a>
          </div>

          <div id="sliders-panel" class="collapse {{(Request::is('backend/slider*') ? 'show' : '')}}" aria-labelledby="sliders-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/slider/add') ? 'active' : '')}}">
                  <a href="{{route('admin.slider.add')}}" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Add new Slider</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/sliders') ? 'active' : '')}}">
                  <a href="{{route('admin.sliders')}}" class="nav-link">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Sliders list</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="tags-wizard">
            <a class="nav-link {{(Request::is('backend/offer*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#deals-panel" data-parent="#sidebar-menu" data-target="#deals-panel" aria-expanded="true" aria-controls="deals-panel">
              <i class="nav-icon fas fa-gift"></i>
              <p>
                Offers
              </p>
            </a>
          </div>

          <div id="deals-panel" class="collapse {{(Request::is('backend/offer*') ? 'show' : '')}}" aria-labelledby="deals-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/offer/add') ? 'active' : '')}}">
                  <a href="{{route('admin.offer.add')}}" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Add New Offer Item</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/offers') ? 'active' : '')}}">
                  <a href="{{route('admin.offers')}}" class="nav-link">
                    <i class="fas fa-list nav-icon"></i>
                    <p>Offers list</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="product-wizard">
            <a class="nav-link {{(Request::is('backend/product*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#product-panel" data-parent="#sidebar-menu" data-target="#product-panel" aria-expanded="true" aria-controls="products-panel">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Products
              </p>
            </a>
          </div>

          <div id="product-panel" class="collapse {{Request::is('backend/product*') ? 'show' : ''}}" aria-labelledby="product-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/products/add') ? 'active' : '')}}">
                  <a href="{{route('admin.product.add')}}" class="nav-link">
                    <i class="nav-icon fas fa-cube"></i>
                    <p>Add Product</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/products') ? 'active' : '')}}">
                  <a href="{{route('admin.products')}}" class="nav-link">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Products List</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/products/archive') ? 'active' : '')}}">
                  <a href="{{route('admin.products.archive')}}" class="nav-link">
                    <i class="nav-icon fas fa-trash-alt"></i>
                    <p>Products Archive</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="reviews-wizard">
            <a class="nav-link {{(Request::is('backend/reviews*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#reviews-panel" data-parent="#sidebar-menu" data-target="#reviews-panel" aria-expanded="true" aria-controls="reviews-panel">
              <i class="nav-icon far fa-star"></i>
              <p>
                Reviews
              </p>
            </a>
          </div>

          <div id="reviews-panel" class="collapse {{Request::is('backend/review*') ? 'show' : ''}}" aria-labelledby="reviews-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/reviews') ? 'active' : '')}}">
                  <a href="{{route('admin.reviews')}}" class="nav-link">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Reviews List</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/reviews/trash') ? 'active' : '')}}">
                  <a href="{{route('admin.reviews.trash')}}" class="nav-link">
                    <i class="nav-icon fas fa-trash-alt"></i>
                    <p>Reviews Trash</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="replies-wizard">
            <a class="nav-link {{(Request::is('backend/replies*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#replies-panel" data-parent="#sidebar-menu" data-target="#replies-panel" aria-expanded="true" aria-controls="replies-panel">
              <i class="nav-icon far fa-smile"></i>
              <p>
                Replies
              </p>
            </a>
          </div>

          <div id="replies-panel" class="collapse {{Request::is('backend/replies*') ? 'show' : ''}}" aria-labelledby="replies-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/replies') ? 'active' : '')}}">
                  <a href="{{route('admin.replies')}}" class="nav-link">
                    <i class="nav-icon fas fa-reply-all"></i>
                    <p>Replies List</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>
      
        <li class="nav-item card">
          <div class="card-header" id="messages-wizard">
            <a class="nav-link {{(Request::is('backend/messages*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#messages-panel" data-parent="#sidebar-menu" data-target="#messages-panel" aria-expanded="true" aria-controls="messages-panel">
              <i class="nav-icon far fa-star"></i>
              <p>
                Messages
              </p>
            </a>
          </div>

          <div id="messages-panel" class="collapse {{Request::is('backend/message*') ? 'show' : ''}}" aria-labelledby="messages-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item {{(Request::is('backend/messages') ? 'active' : '')}}">
                  <a href="{{route('admin.messages')}}" class="nav-link">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Messages List</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item card">
          <div class="card-header" id="orders-wizard">
            <a class="nav-link {{(Request::is('backend/order*') ? '' : 'collapsed')}}" data-toggle="collapse" href="#orders-panel" data-parent="#sidebar-menu" data-target="#orders-panel" aria-expanded="true" aria-controls="orders-panel">
              <i class="nav-icon fa fa-tasks"></i>
              <p>
                Orders
              </p>
            </a>
          </div>

          <div id="orders-panel" class="collapse {{Request::is('backend/order*') ? 'show' : ''}}" aria-labelledby="orders-wizard" data-parent="#sidebar-menu">
            <div class="card-body">
              <ul class="nav">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fa fa-plus nav-icon"></i>
                    <p>New Orders</p>
                  </a>
                </li>
                <li class="nav-item {{(Request::is('backend/orders') ? 'active' : '')}}">
                  <a href="{{route('admin.orders')}}" class="nav-link">
                    <i class="fa fa-tasks nav-icon"></i>
                    <p>View All Orders</p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-th"></i>
            <p>
              Simple Link
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
