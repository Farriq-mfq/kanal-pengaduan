<div class="page-header">
    <h4 class="page-title">Dashboard</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
                <i class="icon-home"></i>
            </a>
        </li>
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route($breadcrumb['link']) }}">{{ $breadcrumb['name'] }}</a>
            </li>
        @endforeach
    </ul>

</div>
