<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparar Todas las Tiendas</title>
    <style>
        /* Estilos para la comparación */
        .comparacion-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .tienda-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        
        .walmart-section { border-left: 4px solid #0071ce; }
        .chedraui-section { border-left: 4px solid #ed1c24; }
        .soriana-section { border-left: 4px solid #00a94f; }
        
        .estadisticas {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Comparar Todas las Tiendas</h1>
            <a href="index.php" class="btn-volver">← Volver al Inicio</a>
        </div>
        
        <div id="comparacion-resultados">
            <div class="loading">
                <div class="spinner"></div>
                <p>Comparando precios entre todas las tiendas...</p>
            </div>
        </div>
    </div>

    <script>
        // Cargar y comparar todos los productos
        window.addEventListener('load', function() {
            const termino = localStorage.getItem('terminoBusqueda') || 'leche';
            compararTodasTiendas(termino);
        });
        
        async function compararTodasTiendas(termino) {
            try {
                const formData = new FormData();
                formData.append('buscar', '1');
                formData.append('termino', termino);
                
                const response = await fetch('scraper.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                mostrarComparacion(data);
                
            } catch (error) {
                document.getElementById('comparacion-resultados').innerHTML = `
                    <div class="error">
                        Error al comparar productos: ${error.message}
                    </div>
                `;
            }
        }
        
        function mostrarComparacion(data) {
            const resultados = document.getElementById('comparacion-resultados');
            
            // Aquí puedes implementar la lógica de comparación
            // usando las funciones que ya tienes en comparador.php
            
            let html = '<div class="comparacion-grid">';
            
            // Mostrar cada tienda
            ['walmart', 'chedraui', 'soriana'].forEach(tienda => {
                const productos = data[tienda] || [];
                html += `
                    <div class="tienda-section ${tienda}-section">
                        <h2>${tienda.charAt(0).toUpperCase() + tienda.slice(1)}</h2>
                        <p><strong>Productos encontrados:</strong> ${Array.isArray(productos) ? productos.length : 0}</p>
                        ${mostrarProductosTienda(productos)}
                    </div>
                `;
            });
            
            html += '</div>';
            resultados.innerHTML = html;
        }
        
        function mostrarProductosTienda(productos) {
            if (!Array.isArray(productos) || productos.length === 0) {
                return '<p>No se encontraron productos</p>';
            }
            
            let html = '';
            productos.slice(0, 5).forEach(prod => {
                html += `
                    <div class="producto-card">
                        <div class="producto-nombre">${prod.nombre}</div>
                        <div class="producto-precio">$${prod.precio.toFixed(2)}</div>
                    </div>
                `;
            });
            
            return html;
        }
    </script>
</body>
</html>