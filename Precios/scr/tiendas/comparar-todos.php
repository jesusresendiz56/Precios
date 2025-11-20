<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparar Todas las Tiendas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        h1 { color: #333; font-size: 2em; }
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
        .producto-buscado {
            color: #ff6b00;
            font-weight: bold;
            font-size: 1.2em;
        }
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
        .tienda-icono { font-size: 2em; margin-right: 12px; }
        .tienda-titulo { font-size: 1.4em; font-weight: bold; }
        .walmart-titulo { color: #0071ce; }
        .chedraui-titulo { color: #ed1c24; }
        .soriana-titulo { color: #00a94f; }
        .productos-lista {
            max-height: 400px;
            overflow-y: auto;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px;
            background: white;
        }
        .productos-lista::-webkit-scrollbar { width: 8px; }
        .productos-lista::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .productos-lista::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        .productos-lista::-webkit-scrollbar-thumb:hover { background: #555; }
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
        .producto-item:last-child { border-bottom: none; }
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
        .loading { text-align: center; padding: 60px; }
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
        .error {
            background: #fee;
            color: #c33;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid #c33;
        }
        @media (max-width: 1200px) {
            .comparacion-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .container { padding: 20px; }
            .header { flex-direction: column; gap: 15px; text-align: center; }
            h1 { font-size: 1.5em; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚖️ Comparar Todas las Tiendas</h1>
            <a href="../index.php" class="btn-volver">← Volver al Inicio</a>
        </div>
        
        <div class="info-box">
            <strong>🔍 Producto buscado:</strong> 
            <span class="producto-buscado" id="producto-buscado">Cargando...</span>
        </div>
        
        <div id="comparacion-resultados">
            <div class="loading">
                <div class="spinner"></div>
                <p>⏳ Comparando precios entre todas las tiendas...</p>
            </div>
        </div>
    </div>

    <script>
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
                
                const response = await fetch('../scraper.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(`Error ${response.status}`);
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
            
            const tiendas = {
                'walmart': { 
                    productos: data.walmart || [], 
                    nombre: 'Walmart', 
                    color: '#0071ce', 
                    icono: '🪙' 
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
                    icono: '🬠' 
                }
            };
            
            const todosProductos = [
                ...tiendas.walmart.productos, 
                ...tiendas.chedraui.productos, 
                ...tiendas.soriana.productos
            ];
            
            if (todosProductos.length === 0) {
                resultados.innerHTML = '<div class="error">No se encontraron productos en ninguna tienda</div>';
                return;
            }
            
            let html = '<div class="comparacion-grid">';
            
            for (const [key, tienda] of Object.entries(tiendas)) {
                const productos = tienda.productos;
                
                html += `
                    <div class="tienda-section ${key}-section">
                        <div class="tienda-header">
                            <span class="tienda-icono">${tienda.icono}</span>
                            <span class="tienda-titulo ${key}-titulo">${tienda.nombre}</span>
                        </div>
                `;
                
                if (!Array.isArray(productos) || productos.length === 0) {
                    html += `<p style="color: #999; text-align: center; padding: 20px;">No se encontraron productos</p>`;
                } else {
                    html += `<div class="productos-lista">`;
                    
                    productos.forEach(prod => {
                        html += `
                            <div class="producto-item">
                                <div class="producto-nombre">${prod.nombre}</div>
                                <div class="producto-precio ${key}-precio">$${prod.precio.toFixed(2)}</div>
                            </div>
                        `;
                    });
                    
                    html += `</div>`;
                }
                
                html += `</div>`;
            }
            
            html += '</div>';
            resultados.innerHTML = html;
        }
    </script>
</body>
</html>