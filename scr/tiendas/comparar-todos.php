<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparar Todas las Tiendas</title>
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
            max-width: 1400px;
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
            border-bottom: 3px solid #ff6b00;
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
            border-left: 4px solid #ff6b00;
        }
        
        .comparacion-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .tienda-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid;
        }
        
        .walmart-section { 
            border-color: #0071ce; 
        }
        
        .chedraui-section { 
            border-color: #ed1c24; 
        }
        
        .soriana-section { 
            border-color: #00a94f; 
        }
        
        .tienda-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .tienda-icono {
            font-size: 1.5em;
            margin-right: 10px;
        }
        
        .tienda-titulo {
            font-size: 1.3em;
            font-weight: bold;
        }
        
        .walmart-titulo { color: #0071ce; }
        .chedraui-titulo { color: #ed1c24; }
        .soriana-titulo { color: #00a94f; }
        
        .tienda-estadisticas {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .estadistica-item {
            background: white;
            padding: 8px;
            border-radius: 6px;
            text-align: center;
            border: 1px solid #ddd;
        }
        
        .estadistica-valor {
            font-weight: bold;
            font-size: 1.1em;
        }
        
        .walmart-valor { color: #0071ce; }
        .chedraui-valor { color: #ed1c24; }
        .soriana-valor { color: #00a94f; }
        
        .estadistica-label {
            font-size: 0.8em;
            color: #666;
        }
        
        .categoria-comparacion {
            margin-bottom: 20px;
        }
        
        .categoria-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 8px;
            background: white;
            border-radius: 6px;
            border-left: 3px solid;
        }
        
        .categoria-icono {
            margin-right: 8px;
            font-size: 1.2em;
        }
        
        .categoria-nombre {
            font-weight: bold;
            flex: 1;
        }
        
        .categoria-cantidad {
            background: #666;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 0.7em;
        }
        
        .productos-lista {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 10px;
        }
        
        .producto-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .producto-item:last-child {
            border-bottom: none;
        }
        
        .producto-nombre {
            font-size: 0.85em;
            flex: 1;
            margin-right: 10px;
        }
        
        .producto-precio {
            font-weight: bold;
            font-size: 0.9em;
        }
        
        .walmart-precio { color: #0071ce; }
        .chedraui-precio { color: #ed1c24; }
        .soriana-precio { color: #00a94f; }
        
        .loading {
            text-align: center;
            padding: 50px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ff6b00;
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
        
        .analisis-general {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 2px solid #ff6b00;
        }
        
        .analisis-titulo {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }
        
        .analisis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .analisis-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        
        .analisis-valor {
            font-size: 1.4em;
            font-weight: bold;
            color: #ff6b00;
            margin-bottom: 5px;
        }
        
        .analisis-label {
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
            
            .comparacion-grid {
                grid-template-columns: 1fr;
            }
            
            .tienda-estadisticas {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Comparar Todas las Tiendas</h1>
            <a href="index.php" class="btn-volver">← Volver al Inicio</a>
        </div>
        
        <div class="info-box">
            <strong>Producto buscado:</strong> <span id="producto-buscado">Cargando...</span>
        </div>
        
        <div id="analisis-general" class="analisis-general" style="display: none;">
            <!-- Análisis general se llenará con JavaScript -->
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
            const termino = localStorage.getItem('terminoBusqueda') || 'lala';
            document.getElementById('producto-buscado').textContent = termino;
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
                
                mostrarComparacionCompleta(data);
                
            } catch (error) {
                document.getElementById('comparacion-resultados').innerHTML = `
                    <div class="error">
                        <strong>Error:</strong> ${error.message}
                    </div>
                `;
            }
        }
        
        function mostrarComparacionCompleta(data) {
            const resultados = document.getElementById('comparacion-resultados');
            const analisisDiv = document.getElementById('analisis-general');
            
            const tiendas = {
                'walmart': { productos: data.walmart || [], nombre: 'Walmart', color: '#0071ce', icono: '🏪' },
                'chedraui': { productos: data.chedraui || [], nombre: 'Chedraui', color: '#ed1c24', icono: '🛒' },
                'soriana': { productos: data.soriana || [], nombre: 'Soriana', color: '#00a94f', icono: '🏬' }
            };
            
            // Calcular análisis general
            const todosProductos = [...tiendas.walmart.productos, ...tiendas.chedraui.productos, ...tiendas.soriana.productos];
            const totalProductos = todosProductos.length;
            const precioMinGlobal = Math.min(...todosProductos.map(p => p.precio));
            const precioMaxGlobal = Math.max(...todosProductos.map(p => p.precio));
            const precioPromedioGlobal = todosProductos.reduce((sum, p) => sum + p.precio, 0) / totalProductos;
            
            // Encontrar mejor precio
            const productoMasBarato = todosProductos.reduce((min, p) => p.precio < min.precio ? p : min, todosProductos[0]);
            
            // Mostrar análisis general
            mostrarAnalisisGeneral(totalProductos, precioMinGlobal, precioMaxGlobal, precioPromedioGlobal, productoMasBarato);
            
            // Construir HTML de comparación
            let html = '<div class="comparacion-grid">';
            
            for (const [key, tienda] of Object.entries(tiendas)) {
                const productos = tienda.productos;
                
                if (!Array.isArray(productos) || productos.length === 0) {
                    html += `
                        <div class="tienda-section ${key}-section">
                            <div class="tienda-header">
                                <span class="tienda-icono">${tienda.icono}</span>
                                <span class="tienda-titulo ${key}-titulo">${tienda.nombre}</span>
                            </div>
                            <p>No se encontraron productos</p>
                        </div>
                    `;
                    continue;
                }
                
                // Agrupar por categoría
                const productosPorCategoria = {};
                productos.forEach(producto => {
                    const categoria = producto.categoria || '🛒 Otros Productos';
                    if (!productosPorCategoria[categoria]) {
                        productosPorCategoria[categoria] = [];
                    }
                    productosPorCategoria[categoria].push(producto);
                });
                
                // Calcular estadísticas de la tienda
                const totalTienda = productos.length;
                const categoriasTienda = Object.keys(productosPorCategoria).length;
                const precioMinTienda = Math.min(...productos.map(p => p.precio));
                const precioMaxTienda = Math.max(...productos.map(p => p.precio));
                const precioPromedioTienda = productos.reduce((sum, p) => sum + p.precio, 0) / totalTienda;
                
                html += `
                    <div class="tienda-section ${key}-section">
                        <div class="tienda-header">
                            <span class="tienda-icono">${tienda.icono}</span>
                            <span class="tienda-titulo ${key}-titulo">${tienda.nombre}</span>
                        </div>
                        
                        <div class="tienda-estadisticas">
                            <div class="estadistica-item">
                                <div class="estadistica-valor ${key}-valor">${totalTienda}</div>
                                <div class="estadistica-label">Productos</div>
                            </div>
                            <div class="estadistica-item">
                                <div class="estadistica-valor ${key}-valor">${categoriasTienda}</div>
                                <div class="estadistica-label">Categorías</div>
                            </div>
                            <div class="estadistica-item">
                                <div class="estadistica-valor ${key}-valor">$${precioMinTienda.toFixed(2)}</div>
                                <div class="estadistica-label">Mínimo</div>
                            </div>
                            <div class="estadistica-item">
                                <div class="estadistica-valor ${key}-valor">$${precioPromedioTienda.toFixed(2)}</div>
                                <div class="estadistica-label">Promedio</div>
                            </div>
                        </div>
                `;
                
                // Mostrar categorías
                for (const [categoria, productosCategoria] of Object.entries(productosPorCategoria)) {
                    const icono = categoria.split(' ')[0];
                    const nombreCategoria = categoria.replace(/^[^\w\s]*\s/, '');
                    
                    html += `
                        <div class="categoria-comparacion">
                            <div class="categoria-header">
                                <span class="categoria-icono">${icono}</span>
                                <span class="categoria-nombre">${nombreCategoria}</span>
                                <span class="categoria-cantidad">${productosCategoria.length}</span>
                            </div>
                            <div class="productos-lista">
                    `;
                    
                    productosCategoria.slice(0, 5).forEach(prod => {
                        html += `
                            <div class="producto-item">
                                <div class="producto-nombre">${prod.nombre}</div>
                                <div class="producto-precio ${key}-precio">$${prod.precio.toFixed(2)}</div>
                            </div>
                        `;
                    });
                    
                    if (productosCategoria.length > 5) {
                        html += `<div style="text-align: center; color: #666; font-size: 0.8em; margin-top: 5px;">+${productosCategoria.length - 5} más</div>`;
                    }
                    
                    html += `
                            </div>
                        </div>
                    `;
                }
                
                html += `</div>`;
            }
            
            html += '</div>';
            resultados.innerHTML = html;
            analisisDiv.style.display = 'block';
        }
        
        function mostrarAnalisisGeneral(total, min, max, promedio, mejorProducto) {
            const analisisDiv = document.getElementById('analisis-general');
            
            analisisDiv.innerHTML = `
                <div class="analisis-titulo">📊 Análisis General de Precios</div>
                <div class="analisis-grid">
                    <div class="analisis-card">
                        <div class="analisis-valor">${total}</div>
                        <div class="analisis-label">Total de Productos</div>
                    </div>
                    <div class="analisis-card">
                        <div class="analisis-valor">$${min.toFixed(2)}</div>
                        <div class="analisis-label">Precio Mínimo</div>
                    </div>
                    <div class="analisis-card">
                        <div class="analisis-valor">$${max.toFixed(2)}</div>
                        <div class="analisis-label">Precio Máximo</div>
                    </div>
                    <div class="analisis-card">
                        <div class="analisis-valor">$${promedio.toFixed(2)}</div>
                        <div class="analisis-label">Precio Promedio</div>
                    </div>
                    <div class="analisis-card">
                        <div class="analisis-valor">${mejorProducto.tienda}</div>
                        <div class="analisis-label">Tienda Más Barata</div>
                    </div>
                    <div class="analisis-card">
                        <div class="analisis-valor">$${mejorProducto.precio.toFixed(2)}</div>
                        <div class="analisis-label">Mejor Precio: ${mejorProducto.nombre}</div>
                    </div>
                </div>
            `;
        }
    </script>
</body>
</html>