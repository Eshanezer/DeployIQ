<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        @php
            $urlNav = Request::route()->getName();
            if (str_contains($urlNav, '.')) {
                $arr = explode('.', $urlNav);
                $urlNav = $arr[count($arr) - 1];
            }
            $urlNav = Str::ucfirst($urlNav);
        @endphp
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Contents</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    {{ $urlNav }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $urlNav }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                        </a>
                    </li>
                    <li class="nav-item px-3 d-flex align-items-center">
                        <a href="{{ route('admin.logout') }}" class="nav-link text-body font-weight-bold px-0">
                            <i class="fa fa-sign-out fixed-plugin-button-nav cursor-pointer"></i>
                            <span class="d-sm-inline d-none">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>
