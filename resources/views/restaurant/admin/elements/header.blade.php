<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">@yield('title', 'Dashboard')</div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item me-3">
                        <a href="{{ route('pos.dashboard') }}" class="btn btn-primary btn-sm">Open POS</a>
                    </li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            <div class="header-info">
                                <span>{{ auth()->user()->name ?? 'Staff' }}</span>
                                <small>{{ auth()->user()->roles->first()?->name ?? '' }}</small>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item ai-icon">Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
