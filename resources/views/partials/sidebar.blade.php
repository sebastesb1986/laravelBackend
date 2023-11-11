@auth
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-tasks"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Administrador de tareas V1.0</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }} ">
        <a class="nav-link" href=" {{ route('home')  }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Menú
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item {{ request()->routeIs('home') || request()->routeIs('home') ? 'active' : '' }} " >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-list-alt"></i>
          <span>Tareas y etiquetas</span>
        </a>
        <div id="collapseTwo" class="collapse {{ request()->routeIs('tk.index') || request()->routeIs('tg.index') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Opciones:</h6>
            <a class="collapse-item {{ request()->routeIs('tk.index') ? 'active' : '' }}" href="{{ route('tk.index') }}">Ver tareas</a>
            <a class="collapse-item {{ request()->routeIs('tg.index') ? 'active' : '' }}" href="{{ route('tg.index') }}">Ver etiquetas</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
  @endauth
  