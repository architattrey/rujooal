
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=url('/')?>/public/dist/img/hemkund_logo.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p> {{ucfirst(Auth::User()->name)}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="{{route('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
           </a>
         
        </li>
        <!-- agents tab -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Categories</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
            
          <ul>
              <li><a href="{{route('category-actions')}}"><i class="fa fa-circle-o"></i>&nbsp;Maintain Categories</a></li>
              <li><a href="{{route('brand-actions')}}"><i class="fa fa-circle-o"></i>&nbsp;Maintain Brands</a></li>
              <li><a href="{{route('products-actions')}}"><i class="fa fa-circle-o"></i>&nbsp;Maintain Products</a></li>
              <li><a href="{{route('trending-products')}}"><i class="fa fa-circle-o"></i>&nbsp;Trending Products</a></li>
              <li><a href="{{route('promocode')}}"><i class="fa fa-circle-o"></i>&nbsp;Promo Code</a></li>
              <li><a href="{{route('app-users')}}"><i class="fa fa-circle-o"></i>&nbsp;Users</a></li>
              <li><a href="{{route('deliveries')}}"><i class="fa fa-circle-o"></i>&nbsp;Delieveries Order</a></li>  
          </ul>
        </li>
        <!-- -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>