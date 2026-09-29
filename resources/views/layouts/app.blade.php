<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    @include('layouts.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    @include('layouts.header')

    <main class="main-content">
        @yield('content')
    </main>

    @include('layouts.footer')
    @include('storefront.themes.default.partials.infomodal')
    @include('storefront.themes.default.partials.cart')
    @include('layouts.scripts')

    @yield('custom-scripts')

    @stack('scripts')
</body>
</html>
