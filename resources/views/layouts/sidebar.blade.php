<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>

	</ul>
  <ul class="navbar-nav ml-auto">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-success">Logout</button>
    </form>
  </ul>
</nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">PT KARYA INOVASI SUKSES</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">{{ UcFirst(Auth::user()->username) }} as {{ Auth::user()->role->name }} </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('explore') }}" class="nav-link {{ (request()->is('explore*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Explore Now
              </p>
            </a>
          </li>
          <li class="nav-item {{ (request()->is('user_management*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('user_management*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link {{ (request()->is('user_management/user*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('permission.index') }}" class="nav-link {{ (request()->is('user_management/permission*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permission</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('role.index') }}" class="nav-link {{ (request()->is('user_management/role*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ (request()->is('master_data*')) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('master_data*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Master Data
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link {{ (request()->is('master_data/category*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('story.index') }}" class="nav-link {{ (request()->is('master_data/story*')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Article</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
