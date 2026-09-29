<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>{{ $client->store_name }} · No disponible</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex align-items-center min-vh-100">
    <main class="container text-center py-5" style="max-width: 520px;">
        <i class="bi bi-shop display-4 text-secondary"></i>
        <h1 class="h3 fw-bold mt-3">{{ $client->store_name }}</h1>
        <p class="text-muted mb-4">
            Esta tienda no está disponible temporalmente. Vuelve pronto.
        </p>
        <p class="small text-muted mb-0">
            Tienda creada con <a href="https://quickweb.com.co" class="text-decoration-none">QuickWeb</a>
        </p>
    </main>
</body>
</html>
