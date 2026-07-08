<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('restaurant.name') }} | @yield('title', 'POS')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    @if(!empty(config('dz.public.global.css')))
        @foreach(config('dz.public.global.css') as $style)
            <link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif
    <style>
        .pos-nav { background:#1e293b; padding:.75rem 1rem; }
        .pos-nav a { color:#cbd5e1; margin-right:1rem; text-decoration:none; font-weight:600; }
        .pos-nav a.active, .pos-nav a:hover { color:#fff; }
        .pos-body { padding:1rem; min-height:80vh; background:#f8fafc; }
        .pos-body--billing { padding:0; overflow:hidden; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="pos-nav d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex flex-wrap align-items-center">
            <strong class="text-white me-3">{{ config('restaurant.name') }} POS</strong>
            @can('pos.access')
            <a class="{{ request()->routeIs('pos.dashboard') ? 'active' : '' }}" href="{{ route('pos.dashboard') }}">New Order</a>
            <a class="{{ request()->routeIs('pos.tables.*') ? 'active' : '' }}" href="{{ route('pos.tables.index') }}">Tables</a>
            <a class="{{ request()->routeIs('pos.orders.*') ? 'active' : '' }}" href="{{ route('pos.orders.index') }}">Orders</a>
            <a class="{{ request()->routeIs('pos.hold.*') ? 'active' : '' }}" href="{{ route('pos.hold.index') }}">Hold</a>
            @endcan
            @can('kitchen.access')
            <a class="{{ request()->routeIs('pos.kitchen.*') ? 'active' : '' }}" href="{{ route('pos.kitchen.index') }}">Kitchen</a>
            @endcan
            @can('pos.access')
            <a class="{{ request()->routeIs('pos.day-close.*') ? 'active' : '' }}" href="{{ route('pos.day-close.index') }}">Day Close</a>
            @endcan
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="text-white-50">Admin</a>
            <span class="text-white-50">{{ auth()->user()->name ?? '' }}</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-outline-light">Logout</button>
            </form>
        </div>
    </div>

    <div class="pos-body @yield('body_class')">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-2 mb-0" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-2 mb-0" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>

    @if(!empty(config('dz.public.global.js.top')))
        @foreach(config('dz.public.global.js.top') as $script)
            <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach
    @endif
    @if(!empty(config('dz.public.global.js.bottom')))
        @foreach(config('dz.public.global.js.bottom') as $script)
            <script src="{{ asset($script) }}" type="text/javascript"></script>
        @endforeach
    @endif
    @stack('scripts')
</body>
</html>
