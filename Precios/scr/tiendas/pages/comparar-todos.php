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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            font-size: 2em;
        }
        
        .btn-volver {
            padding: 12px 24px;
            background: #666;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .btn-volver:hover {
            background: #555;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .info-box {
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 5px solid #ff6b00;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .info-box strong {
            color: #333;
            font-size: 1.1em;
        }
        
        .producto-buscado {
            color: #ff6b00;
            font-weight: bold;
            font-size: 1.2em;
        }
        
        /* Análisis General */
        .analisis-general {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 2px solid #ff6b00;
            box-shadow: 0 4px 15px rgba(255,107,0,0.1);
        }
        
        .analisis-titulo {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .analisis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .analisis-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }
        
        .analisis-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border-color: #ff6b00;
        }
        
        .analisis-valor {
            font-size: 1.8em;
            font-weight: bold;
            color: #ff6b00;
            margin-bottom: 8px;
        }
        
        .analisis-label {
            font-size: 0.95em;
            color: #666;
            font-weight: 500;
        }
        
        /* Grid de Comparación */
        .comparacion-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .tienda-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            border-left: 5px solid;
            transition: all 0.3s;
        }
        
        .tienda-section:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        
        .walmart-section { 
            border-color: #0071ce;
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 100%);
        }
        
        .chedraui-section { 
            border-color: #ed1c24;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffebee 100%);
        }
        
        .soriana-section { 
            border-color: #00a94f;
            background: linear-gradient(135deg, #f8f9fa 0%, #e8f5e9 100%);
        }
        
        .tienda-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .tienda-icono {
            font-size: 2em;
            margin-right: 12px;
        }
        
        .tienda-titulo {
            font-size: 1.4em;
            font-weight: bold;
        }
        
        .walmart-titulo { color: #0071ce; }
        .chedraui-titulo { color: #ed1c24; }
        .soriana-titulo { color: #00a94f; }
        
        .tienda-estadisticas {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .estadistica-item {
            background: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #ddd;
            transition: all 0.3s;
        }
        
        .estadistica-item:hover {
            border-color: #ff6b00;
            transform: scale(1.05);
        }
        
        .estadistica-valor {
            font-weight: bold;
            font-size: 1.3em;
            margin-bottom: 4px;
        }
        
        .walmart-valor { color: #0071ce; }
        .chedraui-valor { color: #ed1c24; }
        .soriana-valor { color: #00a94f; }
        
        .estadistica-label {
            font-size: 0.85em;
            color: #666;
        }
        
        /* Categorías */
        .categoria-comparacion {
            margin-bottom: 20px;
        }
        
        .categoria-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #ff6b00;
            transition: all 0.3s;
        }
        
        .categoria-header:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .categoria-icono {
            margin-right: 10px;
            font-size: 1.3em;
        }
        
        .categoria-nombre {
            font-weight: bold;
            flex: 1;
            color: #333;
        }
        
        .categoria-cantidad {
            background: #ff6b00;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: bold;
        }
        
        /* Lista de Productos */
        .productos-lista {
            max-height: 250px;
            overflow-y: auto;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px;
            background: white;
        }
        
        .productos-lista::-webkit-scrollbar {
            width: 8px;
        }
        
        .productos-lista::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .productos-lista::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        .productos-lista::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        .producto-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.2s;
        }
        
        .producto-item:hover {
            background: #f8f9fa;
            padding-left: 8px;
            border-radius: 4px;
        }
        
        .producto-item:last-child {
            border-bottom: none;
        }
        
        .producto-nombre {
            font-size: 0.9em;
            flex: 1;
            margin-right: 15px;
            color: #333;
        }
        
        .producto-precio {
            font-weight: bold;
            font-size: 1em;
            white-space: nowrap;
        }
        
        .walmart-precio { color: #0071ce; }
        .chedraui-precio { color: #ed1c24; }
        .soriana-precio { color: #00a94f; }
        
        /* Loading */
        .loading {
            text-align: center;
            padding: 60px;
        }
        
        .spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #ff6b00;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading p {
            font-size: 1.1em;
            color: #666;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #c33;
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .comparacion-grid {
                grid-template-columns: 1fr;
            }
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
            
            h1 {
                font-size: 1.5em;
            }
            
            .tienda-estadisticas {
                grid-template-columns: 1fr;
            }
            
            .analisis-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Comparar Todas las Tiendas</h1>
            <!-- CORREGIDO: Ruta con ../ para subir a la carpeta raíz -->
            <a href="../index.php" class="btn-volver">← Volver al Inicio</a>
        </div>
        
        <div class="info-box">
            <strong>🔍 Producto buscado:</strong> 
            <span class="producto-buscado" id="producto-buscado">Cargando...</span>
        </div>
        
        <div id="analisis-general" class="analisis-general" style="display: none;">
            <!-- Análisis general se llenará con JavaScript -->
        </div>
        
        <div id="comparacion-resultados">
            <div class="loading">
                <div class="spinner"></div>
                <p>⏳ Comparando precios entre todas las tiendas...</p>
            </div>
        </div>
    </div>

    <script>
        // Cargar y comparar todos los productos
        window.addEventListener('load', function() {
            const termino = localStorage.getItem('terminoBusqueda') || 'papel higienico';
            document.getElementById('producto-buscado').textContent = termino;
            compararTodasTiendas(termino);
        });
        
        async function compararTodasTiendas(termino) {
            try {
                const formData = new FormData();
                formData.append('buscar', '1');
                formData.append('termino', termino);
                
                // CORREGIDO: Ruta con ../ para subir a la carpeta raíz
                const response = await fetch('../scraper.php', {
                    method: 'POST',
                    body: formData
                });
                
                const text = await response.text();
                let data;
                
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error('Error al procesar la respuesta del servidor');
                }
                
                if (!response.ok) {
                    throw new Error(`Error ${response.status}: ${response.statusText}`);
                }
                
                mostrarComparacionCompleta(data);
                
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('comparacion-resultados').innerHTML = `
                    <div class="error">
                        <strong>❌ Error al comparar productos:</strong><br>
                        ${error.message}
                    </div>
                `;
            }
        }
        
        function mostrarComparacionCompleta(data) {
            const resultados = document.getElementById('comparacion-resultados');
            const analisisDiv = document.getElementById('analisis-general');
            
            const tiendas = {
                'walmart': { 
                    productos: data.walmart || [], 
                    nombre: 'Walmart', 
                    color: '#0071ce', 
                    icono: '🏪' 
                },
                'chedraui': { 
                    productos: data.chedraui || [], 
                    nombre: 'Chedraui', 
                    color: '#ed1c24', 
                    icono: '🛒' 
                },
                'soriana': { 
                    productos: data.soriana || [], 
                    nombre: 'Soriana', 
                    color: '#00a94f', 
                    icono: '🏬' 
                }
            };
            
            // Calcular análisis general
            const todosProductos = [
                ...tiendas.walmart.productos, 
                ...tiendas.chedraui.productos, 
                ...tiendas.soriana.productos
            ];
            
            if (todosProductos.length === 0) {
                resultados.innerHTML = '<div class="error">No se encontraron productos en ninguna tienda</div>';
                return;
            }
            
            const totalProductos = todosProductos.length;
            const precioMinGlobal = Math.min(...todosProductos.map(p => p.precio));
            const precioMaxGlobal = Math.max(...todosProductos.map(p => p.precio));
            const precioPromedioGlobal = todosProductos.reduce((sum, p) => sum + p.precio, 0) / totalProductos;
            
            // Encontrar mejor precio y tienda más barata
            const productoMasBarato = todosProductos.reduce((min, p) => 
                p.precio < min.precio ? p : min, todosProductos[0]
            );
            
            // Encontrar tienda con precio promedio más bajo
            const promediosPorTienda = {};
            for (const [key, tienda] of Object.entries(tiendas)) {
                if (tienda.productos.length > 0) {
                    promediosPorTienda[key] = {
                        nombre: tienda.nombre,
                        promedio: tienda.productos.reduce((sum, p) => sum + p.precio, 0) / tienda.productos.length
                    };
                }
            }
            
            const tiendaMasBarata = Object.values(promediosPorTienda).reduce((min, t) => 
                t.promedio < min.promedio ? t : min, Object.values(promediosPorTienda)[0]
            );
            
            // Mostrar análisis general
            mostrarAnalisisGeneral(
                totalProductos, 
                precioMinGlobal, 
                precioMaxGlobal, 
                precioPromedioGlobal, 
                productoMasBarato,
                tiendaMasBarata
            );
            
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
                            <p style="color: #999; text-align: center; padding: 20px;">
                                No se encontraron productos
                            </p>
                        </div>
                    `;
                    continue;
                }
                
                // Agrupar por categoría
                const productosPorCategoria = {};
                productos.forEach(producto => {
                    const categoria = producto.categoria || '🛍️ Otros Productos';
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
                    
                    productosCategoria.slice(0, 10).forEach(prod => {
                        html += `
                            <div class="producto-item">
                                <div class="producto-nombre">${prod.nombre}</div>
                                <div class="producto-precio ${key}-precio">$${prod.precio.toFixed(2)}</div>
                            </div>
                        `;
                    });
                    
                    if (productosCategoria.length > 10) {
                        html += `
                            <div style="text-align: center; color: #999; font-size: 0.85em; margin-top: 10px; font-style: italic;">
                                📦 +${productosCategoria.length - 10} productos más
                            </div>
                        `;
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
        
        function mostrarAnalisisGeneral(total, min, max, promedio, mejorProducto, tiendaMasBarata) {
            const analisisDiv = document.getElementById('analisis-general');
            const diferencia = max - min;
            const ahorroPorcentaje = ((diferencia / max) * 100).toFixed(1);
            
            analisisDiv.innerHTML = `
                <div class="analisis-titulo">
                    📊 Análisis General de Precios
                </div>
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
                        <div class="analisis-valor">${tiendaMasBarata.nombre}</div>
                        <div class="analisis-label">Tienda Más Económica</div>
                    </div>
                    <div class="analisis-card">
                        <div class="analisis-valor">${ahorroPorcentaje}%</div>
                        <div class="analisis-label">Ahorro Potencial</div>
                    </div>
                </div>
            `;
        }
    </script>
</body>
</html>