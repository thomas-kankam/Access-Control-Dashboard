<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <div class="card-body">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center justify-content-first mb-2">
                    <img src="{{ asset('assets/img/gt.png') }}" width="70" alt="app-logo">
                </a>
            </div>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Home">Home</span>
        </li>
        <!-- Dashboards -->
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        {{-- Settings --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Settings">Settings</span>
        </li>
        <li class="menu-item {{ request()->is('settings') ? 'active' : '' }}">
            <a href="{{ route('settings.index') }}" class="menu-link">
                <i class='menu-icon bx bx-barcode-reader'></i>
                <div class="text-truncate" data-i18n="RFID">RFID</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('staffs') ? 'active' : '' }}">
            <a href="{{ route('get.staffs') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-chalkboard-user"></i>
                <div class="text-truncate" data-i18n="Staffs">Staffs</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('students') ? 'active' : '' }}">
            <a href="{{ route('get.students') }}" class="menu-link">
                <i class="menu-icon fa-duotone fa-solid fa-graduation-cap"></i>
                <div class="text-truncate" data-i18n="Students">Students</div>
            </a>
        </li>

        {{-- Leads --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Logs">Logs</span>
        </li>
        <li class="menu-item {{ request()->is('logs') ? 'active' : '' }}">
            <a href="{{ route('logs') }}" class="menu-link">
                <i class="menu-icon fas fa-angle-double-down mb-2"></i>
                <div class="text-truncate" data-i18n="Logs">Logs</div>
            </a>
        </li>

        {{-- Account --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text" data-i18n="Account">Account</span>
        </li>
        <li class="menu-item">
            <a href="{{ route('get.users') }}" class="menu-link">
                <i class="menu-icon fa-solid fa-user"></i>
                <div class="text-truncate" data-i18n="Users">Users</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('logout') ? 'active' : '' }}">
            <a href="{{ route('logout') }}" class="menu-link"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div class="text-truncate" data-i18n="Logout">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
                {{-- send the email as hidden to the logout endpoint --}}
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
            </form>
        </li>
    </ul>
</aside>
