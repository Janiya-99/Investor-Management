<li class="pc-item pc-caption">
    <label>Navigation</label>
  </li>

  <li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
      <span class="pc-micon">
        <i class="ph-duotone ph-gauge"></i>
      </span>
      <span class="pc-mtext">Dashboard</span>
      <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
      {{-- <span class="pc-badge">2</span> --}}
    </a>
    {{-- <ul class="pc-submenu">
      <li class="pc-item"><a class="pc-link" href="/dashboard">Analytics</a></li>
      <li class="pc-item"><a class="pc-link" href="/affiliate">Affiliate</a></li>
      <li class="pc-item"><a class="pc-link" href="/finance">Finance</a></li>
      <li class="pc-item"><a class="pc-link" href="/admins/helpdesk-dashboard">Helpdesk</a></li>
      <li class="pc-item"><a class="pc-link" href="/invoice">invoice</a></li>
    </ul> --}}
  </li>

  @can('users.view')
  <li class="pc-item">
    <a href="{{route('users.index')}}" class="pc-link">
      <span class="pc-micon">
        <i class="ph-duotone ph-users"></i>
      </span>
      <span class="pc-mtext">Users</span>
    </a>
  </li>
  @endcan

  @can('roles.view')
  <li class="pc-item">
    <a href="{{route('roles.index')}}" class="pc-link">
      <span class="pc-micon">
        <i class="ph-duotone ph-shield-check"></i>
      </span>
      <span class="pc-mtext">Roles</span>
    </a>
  </li>
  @endcan

  @can('permissions.view')
  <li class="pc-item">
    <a href="{{route('permissions.index')}}" class="pc-link">
      <span class="pc-micon">
        <i class="ph-duotone ph-key"></i>
      </span>
      <span class="pc-mtext">Permissions</span>
    </a>
  </li>
  @endcan

  @can('products.view')
  <li class="pc-item">
    <a href="{{route('products.index')}}" class="pc-link">
      <span class="pc-micon">
        <i class="ph-duotone ph-tag"></i>
      </span>
      <span class="pc-mtext">Product</span>
    </a>
  </li>
  @endcan

  @canany(['investors.view', 'investors.create'])
  <li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link">
      <span class="pc-micon">
        <i class="ph-duotone ph-users-three"></i>
      </span>
      <span class="pc-mtext">Investor</span>
      <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
      {{-- <span class="pc-badge">2</span> --}}
    </a>
    <ul class="pc-submenu">
      @can('investors.create')
      <li class="pc-item"><a class="pc-link" href="{{route('investors.create')}}">Create Investor</a></li>
      @endcan
      @can('investors.view')
      <li class="pc-item"><a class="pc-link" href="{{route('investors.index')}}">Investors List</a></li>
      <li class="pc-item"><a class="pc-link" href="{{route('investors.index')}}"> Documents</a></li>
      <li class="pc-item"><a class="pc-link" href="{{route('investors.index')}}"> Bank Details</a></li>
      @endcan
      {{--
      <li class="pc-item"><a class="pc-link" href="/finance">Finance</a></li>
      <li class="pc-item"><a class="pc-link" href="/admins/helpdesk-dashboard">Helpdesk</a></li>
      <li class="pc-item"><a class="pc-link" href="/invoice">invoice</a></li> --}}
    </ul>
  </li>
  @endcanany
