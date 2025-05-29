<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo" style="color: white" class="d-flex">
                <img src="{{ asset('assets/img/logo-tab.svg') }}" alt="navbar brand" class="navbar-brand"
                    height="40" />
                <span class="ms-3 fw-bold">
                    {{ config('app.name') }}
                </span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li @class(['nav-item', 'active' => is_active('dashboard')])>
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Aduan</h4>
                </li>
                <li @class(['nav-item', 'active' => is_active('aduan.')])>
                    <a href="{{ route('aduan.index') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Daftar Aduan</p>
                        {{-- <span class="badge badge-success">4</span> --}}
                    </a>
                </li>
                <li @class(['nav-item', 'active' => is_active('tracking')])>
                    <a href="{{ route('tracking') }}">
                        <i class="fas fa-chart-bar"></i>
                        <p>Tracking Aduan</p>
                    </a>
                </li>
                @can(['klasifikasi view', 'users view', 'roles view'])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Master Data</h4>
                    </li>
                @endcan
                @can('klasifikasi view')
                    <li @class(['nav-item', 'active' => is_active('klasifikasi.index')])>
                        <a href="{{ route('klasifikasi.index') }}">
                            <i class="fas fa-list"></i>
                            <p>Klasifikasi</p>
                            {{-- <span class="badge badge-success">4</span> --}}
                        </a>
                    </li>
                @endcan
                @can('kategori view')
                    <li @class(['nav-item', 'active' => is_active('kategori.index')])>
                        <a href="{{ route('kategori.index') }}">
                            <i class="fas fa-list-alt"></i>
                            <p>Kategori</p>
                            {{-- <span class="badge badge-success">4</span> --}}
                        </a>
                    </li>
                @endcan
                @can('users view')
                    <li @class(['nav-item', 'active' => is_active('users.index')])>
                        <a href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i>
                            <p>Users</p>
                            {{-- <span class="badge badge-success">4</span> --}}
                        </a>
                    </li>
                @endcan
                @can('roles view')
                    <li @class(['nav-item', 'active' => is_active('roles.index')])>
                        <a href="{{ route('roles.index') }}">
                            <i class="fas fa-key"></i>
                            <p>Hak Akses</p>
                            {{-- <span class="badge badge-success">4</span> --}}
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>

{{-- @push('scripts')
    <script>
        const $navItems = $(document).find('.nav-item');
        console.log($navItems);
        $navItems.find('a').each(function() {
            const href = $(this).attr('href')
        });
    </script>
@endpush --}}
