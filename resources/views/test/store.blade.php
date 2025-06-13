<!-- resources/views/test/store.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Prueba de Tienda</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .store { margin-bottom: 30px; }
        .category { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; }
        .product { border-left: 3px solid #3490dc; padding: 10px; margin: 10px 0; }
        .product-image { max-width: 100px; max-height: 100px; }
    </style>
</head>
<body>
    <h1>Prueba de Datos de Tienda</h1>

    <div id="store-data">
        <p>Cargando datos...</p>
    </div>

    <script>
        // Obtener el dominio de la URL
        const domain = window.location.pathname.split('/')[3] || 'tienda1.test';
        console.log('Dominio de la tienda:', domain);

        // Fetch a la API
        fetch(`/api/store/${domain}`)
            .then(response => {
                console.log('Respuesta de la API:', response);
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la API');
                }
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    renderStore(data);
                } else {
                    showError(data.message || 'Error en los datos recibidos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('No se pudo conectar con la API');
            });

        function showError(message) {
            document.getElementById('store-data').innerHTML = `
                <div class="error" style="color: red; padding: 10px; border: 1px solid red;">
                    <strong>Error:</strong> ${message}
                </div>
            `;
        }

        function renderStore(data) {
            let html = `
                <div class="store">
                    <h2>${data.client.store_name}</h2>
                    <p>${data.client.primary_color} - ${data.client.secondary_color}</p>
                    <p>${data.client.theme}</p>
                    <p>${data.client.font}</p>
                    <p>${data.client.timezone}</p>
                    <p>${data.client.site_settings.about_text}</p>

                    <hr>
            `;

            // Mostrar categorías y productos
            data.categories.forEach(category => {
                html += `
                    <div class="category">
                        <h3>${category.name}</h3>
                        ${category.description ? `<p>${category.description}</p>` : ''}
                `;

                if(category.products && category.products.length > 0) {
                    category.products.forEach(product => {
                        html += `
                            <div class="product">
                                <h4>${product.name} - $${product.price}</h4>
                                <p>${product.description.substring(0, 100)}...</p>
                        `;

                        if(product.image && product.image.length > 0) {
                            html += `<img src="${product.image[0].alt_text}" class="product-image">`;
                        }

                        html += `</div>`;
                    });
                } else {
                    html += `<p>No hay productos en esta categoría</p>`;
                }

                html += `</div>`;
            });

            html += `</div>`;
            document.getElementById('store-data').innerHTML = html;
        }
    </script>
</body>
</html>
