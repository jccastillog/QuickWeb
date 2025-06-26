<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    @include('layouts.head')
</head>
<body>
    @include('layouts.header')
    
    <main class="main-content">
        @yield('content')
    </main>
    
    @include('layouts.footer')
    @include('storefront.themes.default.partials.infomodal')
    @include('layouts.scripts')
    
    @yield('custom-scripts')

    @stack('scripts')
</body>
</html>