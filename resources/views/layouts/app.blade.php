<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    @include('layouts.head')
</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-2DD4RTEQJX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-2DD4RTEQJX');
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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