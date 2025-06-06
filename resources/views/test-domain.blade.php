<!DOCTYPE html>
<html>
<head>
    <title>Prueba Multi-Dominio</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .client-info { background: #f0f0f0; padding: 20px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="client-info">
        <h1>{{ $client->store_name }}</h1>
        <p>Dominio: <strong>{{ $client->domain }}</strong></p>
        <p>ID Cliente: <strong>{{ $client->id }}</strong></p>
    </div>
    
    <h2>Categorías</h2>
    <ul>
        @foreach($categories as $category)
            <li>{{ $category->name }} - {{ $category->description }}</li>
        @endforeach
    </ul>
    
    <h3>Prueba los clientes:</h3>
    <a href="/test-multi-domain/1" class="btn">Cliente 1</a>
    <a href="/test-multi-domain/2" class="btn">Cliente 2</a>
</body>
</html>