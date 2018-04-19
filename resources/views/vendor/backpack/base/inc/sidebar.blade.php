@if (backpack_auth()->check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        @include('backpack::inc.sidebar_user_panel')

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->

          @include('backpack::inc.sidebar_content')

          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}
              <li class="treeview">
                  <a href="#"><i class="fa fa-newspaper-o"></i> <span>News</span> <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/article') }}"><i class="fa fa-newspaper-o"></i> <span>Articles</span></a></li>
                      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/category') }}"><i class="fa fa-list"></i> <span>Categories</span></a></li>
                      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/tag') }}"><i class="fa fa-tag"></i> <span>Tags</span></a></li>
                  </ul>
              </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
