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
                <li><a href="{{ route('home') }}" class="{{ is_active('home') ? 'active' : '' }}">Beranda<br></a>
                </li>
                {{-- <li><a href="{{ route('home') }}" class="{{ is_active('home') ? 'active' : '' }}">Tracking Aduan<br></a>
                </li> --}}
                <li><a href="{{ route('about') }}" class="{{ is_active('about') ? 'active' : '' }}">Tentang
                        {{ config('app.name') }}</a></li>
                {{-- <li><a href="{{ route('home') }}" class="{{ is_active('about') ? 'active' : '' }}">Aduan Saya</a></li> --}}
                @if (auth('masyarakat')->check())
                    <li class="dropdown"><a href="#"><span>{{ auth('masyarakat')->user()->name }}</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li>
                                <a href="#">
                                    Profile
                                </a>
                            </li>
                            <li class="p-2">
                                <form action="{{ route('front.logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-pr">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        @if (!auth('masyarakat')->check())
            <a class="btn-getstarted" href="{{ route('front.login') }}">
                Login / Register
            </a>
        @endif

    </div>
</header>
