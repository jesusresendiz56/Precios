<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soriana - Comparador de Precios</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh; 
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #00a94f;
        }
        
        h1 {
            color: #333;
        }
        
        .btn-volver {
            padding: 10px 20px;
            background: #666;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }
        
        .btn-volver:hover {
            background: #555;
        }
        
        .info-box {
            background: #f0f8ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #00a94f;
        }
        
        .categoria {
            margin-bottom: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid #00a94f;
        }
        
        .categoria-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .categoria-icono {
            font-size: 1.5em;
            margin-right: 10px;
        }
        
        .categoria-titulo {
            font-size: 1.3em;
            font-weight: bold;
            color: #333;
        }
        
        .categoria-cantidad {
            background: #00a94f;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: 10px;
        }
        
        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 15px;
        }
        
        .producto-card {
            border: 2px solid #00a94f;
            border-radius: 10px;
            padding: 15px;
            background: white;
            transition: transform 0.3s;
        }
        
        .producto-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 169, 79, 0.2);
        }
        
        .producto-nombre {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95em;
            line-height: 1.4;
        }
        
        .producto-precio {
            color: #00a94f;
            font-size: 1.3em;
            font-weight: bold;
            margin: 8px 0;
        }
        
        .producto-tienda {
            color: #666;
            font-size: 0.9em;
            font-style: italic;
        }
        
        .producto-marca {
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            color: #495057;
            display: inline-block;
            margin-top: 5px;
        }
        
        .loading {
            text-align: center;
            padding: 50px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #00a94f;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 4px solid #c33;
        }
        
        .estadisticas {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .estadistica-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            flex: 1;
            min-width: 150px;
            text-align: center;
        }
        
        .estadistica-valor {
            font-size: 1.5em;
            font-weight: bold;
            color: #00a94f;
        }
        
        .estadistica-label {
            font-size: 0.9em;
            color: #666;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .productos-grid {
                grid-template-columns: 1fr;
            }
            
            .estadisticas {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏬 Soriana - Productos</h1>
            <a href="index.php" class="btn-volver">← Volver al Inicio</a>
        </div>
        
        <div class="info-box">
            <strong>Producto buscado:</strong> <span id="producto-buscado">Cargando...</span>
            <div id="estadisticas-tienda" class="estadisticas" style="display: none;">
                <!-- Las estadísticas se llenarán con JavaScript -->
            </div>
        </div>
        
        <div id="resultados">
            <div class="loading">
                <div class="spinner"></div>
                <p>Cargando productos de Soriana...</p>
            </div>
        </div>
    </div>

    <script>
        // Cargar productos de Soriana al iniciar
        window.addEventListener('load', function() {
            const termino = localStorage.getItem('terminoBusqueda') || 'lala';
            document.getElementById('producto-buscado').textContent = termino;
            cargarProductosSoriana(termino);
        });
        
        async function cargarProductosSoriana(termino) {
            try {
                const formData = new FormData();
                formData.append('buscar', '1');
                formData.append('termino', termino);
                
                const response = await fetch('scraper.php', {
                    method: 'POST',
                    body: formData
                });
                
                const text = await response.text();
                let data;
                
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error('Error en la respuesta del servidor');
                }
                
                if (!response.ok) {
                    throw new Error(`Error ${response.status}: ${response.statusText}`);
                }
                
                mostrarProductosSoriana(data.soriana || []);
                
            } catch (error) {
                document.getElementById('resultados').innerHTML = `
                    <div class="error">
                        <strong>Error:</strong> ${error.message}
                    </div>
                `;
            }
        }
        
        function mostrarProductosSoriana(productos) {
            const resultados = document.getElementById('resultados');
            
            if (productos.error) {
                resultados.innerHTML = `
                    <div class="error">
                        ${productos.error}
                    </div>
                `;
                return;
            }
            
            if (!Array.isArray(productos) || productos.length === 0) {
                resultados.innerHTML = '<p>No se encontraron productos en Soriana</p>';
                return;
            }
            
            // Agrupar productos por categoría
            const productosPorCategoria = {};
            productos.forEach(producto => {
                const categoria = producto.categoria || '🛒 Otros Productos';
                if (!productosPorCategoria[categoria]) {
                    productosPorCategoria[categoria] = [];
                }
                productosPorCategoria[categoria].push(producto);
            });
            
            // Calcular estadísticas
            const totalProductos = productos.length;
            const categoriasCount = Object.keys(productosPorCategoria).length;
            const precioMin = Math.min(...productos.map(p => p.precio));
            const precioMax = Math.max(...productos.map(p => p.precio));
            const precioPromedio = productos.reduce((sum, p) => sum + p.precio, 0) / totalProductos;
            
            // Mostrar estadísticas
            mostrarEstadisticas(totalProductos, categoriasCount, precioMin, precioMax, precioPromedio);
            
            // Construir HTML con categorías
            let html = '';
            
            for (const [categoria, productosCategoria] of Object.entries(productosPorCategoria)) {
                const icono = categoria.split(' ')[0];
                const nombreCategoria = categoria.replace(/^[^\w\s]*\s/, '');
                
                html += `
                    <div class="categoria">
                        <div class="categoria-header">
                            <span class="categoria-icono">${icono}</span>
                            <span class="categoria-titulo">${nombreCategoria}</span>
                            <span class="categoria-cantidad">${productosCategoria.length} productos</span>
                        </div>
                        <div class="productos-grid">
                `;
                
                productosCategoria.forEach(prod => {
                    html += `
                        <div class="producto-card">
                            <div class="producto-nombre">${prod.nombre}</div>
                            <div class="producto-precio">$${prod.precio.toFixed(2)}</div>
                            <div class="producto-tienda">${prod.tienda}</div>
                            ${prod.marca ? `<div class="producto-marca">${prod.marca}</div>` : ''}
                        </div>
                    `;
                });
                
                html += `
                        </div>
                    </div>
                `;
            }
            
            resultados.innerHTML = html;
        }
        
        function mostrarEstadisticas(total, categorias, min, max, promedio) {
            const estadisticasDiv = document.getElementById('estadisticas-tienda');
            
            estadisticasDiv.innerHTML = `
                <div class="estadistica-card">
                    <div class="estadistica-valor">${total}</div>
                    <div class="estadistica-label">Total Productos</div>
                </div>
                <div class="estadistica-card">
                    <div class="estadistica-valor">${categorias}</div>
                    <div class="estadistica-label">Categorías</div>
                </div>
                <div class="estadistica-card">
                    <div class="estadistica-valor">$${min.toFixed(2)}</div>
                    <div class="estadistica-label">Precio Mínimo</div>
                </div>
                <div class="estadistica-card">
                    <div class="estadistica-valor">$${max.toFixed(2)}</div>
                    <div class="estadistica-label">Precio Máximo</div>
                </div>
                <div class="estadistica-card">
                    <div class="estadistica-valor">$${promedio.toFixed(2)}</div>
                    <div class="estadistica-label">Precio Promedio</div>
                </div>
            `;
            
            estadisticasDiv.style.display = 'flex';
        }
    </script>
</body>
</html>