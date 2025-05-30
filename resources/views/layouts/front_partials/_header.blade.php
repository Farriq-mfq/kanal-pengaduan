<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('/assets/img/logo-tab.svg') }}" alt="">
            <h1 class="sitename">
                {{ config('app.name') }}
            </h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ is_active('home') ? 'active' : '' }}">Tracking Aduan<br></a>
                </li>
                <li><a href="{{ route('about') }}" class="{{ is_active('about') ? 'active' : '' }}">Tentang
                        {{ config('app.name') }}</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted" href="#about">
            Login / Register
        </a>

    </div>
</header>
