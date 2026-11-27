<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - BMB Admin</title>
    <link rel="icon" href="{{ asset('images/bmb.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin">
    <header class="admin-bar">
        <a href="{{ route('admin.products.index') }}" class="admin-brand">
            <img src="{{ asset('images/bmb.png') }}" alt="">
            <span>BMB <small>Admin</small></span>
        </a>

        <nav class="admin-nav">
            <a href="{{ route('admin.products.index') }}" @class(['active' => request()->routeIs('admin.products.*')])>
                <i class="fas fa-boxes-stacked"></i> Items
            </a>
            <a href="{{ route('admin.categories.index') }}" @class(['active' => request()->routeIs('admin.categories.*')])>
                <i class="fas fa-layer-group"></i> Categories
            </a>
            <a href="{{ route('home') }}" target="_blank">
                <i class="fas fa-arrow-up-right-from-square"></i> View website
            </a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="admin-user">
            @csrf
            <span>{{ auth()->user()->name }}</span>
            <button type="submit" class="btn btn-outline btn-sm">Log out</button>
        </form>
    </header>

    <main class="admin-main">
        @if (session('status'))
            <div class="alert alert-success"><i class="fas fa-circle-check"></i> {{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-circle-exclamation"></i>
                <div>
                    <strong>Please fix the following:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
