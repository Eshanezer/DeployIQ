<aside
    class="sidenav navbar text-white bg-dark navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 text-center" href="{{ route('home') }}" target="_blank">
            <h4 class="ms-1 font-weight-bold text-white">{{ config('app.name', 'Laravel') }}</h4>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @php
                $url = Request::url();
            @endphp
            @php
                $sidebar = [
                    [
                        'icon' => 'fa-solid fa-house',
                        'route' => route('home'),
                        'name' => 'Home',
                    ],
                    [
                        'icon' => 'fa-solid fa-sticky-note',
                        'route' => route('admin.logs.index'),
                        'name' => 'Logs',
                    ],
                    [
                        'icon' => 'fa-solid fa-user',
                        'route' => route('admin.users.index'),
                        'name' => 'Users',
                    ],
                    [
                        'icon' => 'fa-solid fa-gear',
                        'route' => route('admin.usertypes.index'),
                        'name' => 'Permissions',
                    ],
                ];
            @endphp
            @foreach ($sidebar as $route)
                @if (doPermitted('//' . explode('/', $route['route'])[3]))
                    <li class="nav-item">
                        <a class="nav-link {{ $url == $route['route'] ? 'active' : '' }}" href="{{ $route['route'] }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="{{ $route['icon'] }} {{ $url == $route['route'] ? '' : 'text-dark' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1 {{ $url == $route['route'] ? '' : 'text-white' }}">{{ $route['name'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach


        </ul>
    </div>
</aside>
