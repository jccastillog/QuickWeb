<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- CSS Personalizado -->
    <link href="{{ asset('assets/pageadmin/css/admin.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="admin-body">
    <!-- Wrapper temporal sin auth -->
    <div class="d-flex">
        <!-- Sidebar Temporal -->
        <div class="admin-sidebar bg-ligthg text-black p-3">
            <div class="sidebar-header mb-4">
                <h4 class="text-center">
                    <i class="bi bi-shop"></i> Administrar Clientes
                </h4>
            </div>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ route('clients.index') }}"
                        class="nav-link text-white {{ request()->is('clients*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill me-2"></i> Gestionar Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('welcome') }}"
                        class="nav-link text-black">
                        <i class="bi bi-people-fill me-2"></i> Página Inicial
                    </a>
                </li>
                <!-- Agregar más items luego -->
            </ul>
        </div>

        <!-- Main Content -->
        <div class="admin-main flex-grow-1">
            <!-- Top Bar Temporal -->
            <nav class="admin-topbar navbar navbar-expand navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-sm sidebar-toggle d-md-none">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="ms-auto">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-box-arrow-right"></i> Salir
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Contenido Principal -->
            <main class="admin-content p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap Bundle + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts Base -->
    <script>
        // Toggle sidebar en móviles
        document.querySelector('.sidebar-toggle')?.addEventListener('click', () => {
            document.querySelector('.admin-sidebar').classList.toggle('d-none');
        });
    </script>

    @stack('scripts')
</body>

</html>
