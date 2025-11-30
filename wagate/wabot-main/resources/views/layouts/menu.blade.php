<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/img/logo.svg') }}" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{ route('dashboard') }}" class="nav-link"> WA </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu{{ request()->routeIs('dashboard') ? ' active' : '' }}">
                <a href="{{ route('dashboard') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>{{ __('Dashboard') }}</span>
                    </div>
                </a>
            </li>

            <li class="menu{{ request()->routeIs('template.*') ? ' active' : '' }}">
                <a href="#template" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('template.*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span>Templates</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ request()->routeIs('template.*') ? 'show' : '' }}" id="template" data-bs-parent="#accordionExample">
                    <li class="{{ request()->routeIs('template.notifikasi.edit') ? 'active' : '' }}">
                        <a href="{{ route('template.notifikasi.edit') }}"> Notifikasi </a>
                    </li>
                    <li class="{{ request()->routeIs('template.autoresponse.edit') ? 'active' : '' }}">
                        <a href="{{ route('template.autoresponse.edit') }}"> Auto Reply Dynamic </a>
                    </li>
                </ul>
            </li>

            <li class="menu{{ request()->routeIs('perintah.*') ? ' active' : '' }}">
                <a href="#perintah" data-bs-toggle="collapse" aria-expanded="{{ request()->routeIs('perintah.*') ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Auto Reply Static</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ request()->routeIs('perintah.*') ? 'show' : '' }}" id="perintah" data-bs-parent="#accordionExample">
                    <li class="{{ request()->routeIs('perintah.create') ? 'active' : '' }}">
                        <a href="{{ route('perintah.create') }}"> New </a>
                    </li>
                    <li class="{{ request()->routeIs('perintah.index') ? 'active' : '' }}">
                        <a href="{{ route('perintah.index') }}"> List </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
