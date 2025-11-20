<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walmart - Comparador de Precios</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #0071ce 0%, #004c91 100%);
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
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #0071ce;
        }
        
        h1 {
            color: #0071ce;
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
        
        .buscador-interno {
            background: #f0f8ff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #0071ce;
        }
        
        .search-box {
            display: flex;
            gap: 10px;
        }
        
        .search-input {
            flex: 1;
            padding: 12px;
            font-size: 1em;
            border: 2px solid #ddd;
            border-radius: 8px;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #0071ce;
        }
        
        .btn-buscar {
            padding: 12px 30px;
            background: #0071ce;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .btn-buscar:hover {
            background: #005a9e;
        }
        
        .info-box {
            background: #f0f8ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #0071ce;
        }
        
        .categoria {
            margin-bottom: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid #0071ce;
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
            background: #0071ce;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: 10px;
        }
        
        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .producto-card {
            border: 2px solid #0071ce;
            border-radius: 10px;
            padding: 15px;
            background: white;
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        
        .producto-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 113, 206, 0.2);
        }
        
        .producto-imagen {
            width: 100%;
            height: 180px;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 10px;
            background: #f8f9fa;
        }
        
        .producto-nombre {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95em;
            line-height: 1.4;
            min-height: 60px;
        }
        
        .producto-marca {
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            color: #495057;
            display: inline-block;
            margin-bottom: 8px;
        }
        
        .producto-precio {
            color: #0071ce;
            font-size: 1.4em;
            font-weight: bold;
            margin: 8px 0;
        }
        
        .producto-precio-antes {
            color: #999;
            font-size: 0.9em;
            text-decoration: line-through;
        }
        
        .disponibilidad {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            margin-bottom: 8px;
            display: inline-block;
        }
        .disponible {
            background: #d4edda;
            color: #155724;
        }
        .pocas-piezas {
            background: #fff3cd;
            color: #856404;
        }
        .sin-stock {
            background: #f8d7da;
            color: #721c24;
        }
        
        .loading {
            text-align: center;
            padding: 50px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0071ce;
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
            color: #0071ce;
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
            
            .search-box {
                flex-direction: column;
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
            <h1>🪙 Walmart - Productos</h1>
            <a href="../index.php" class="btn-volver">← Volver al Inicio</a>
        </div>
        
        <div class="buscador-interno">
            <div class="search-box">
                <input 
                    type="text" 
                    class="search-input" 
                    id="busqueda-walmart" 
                    placeholder="Buscar producto específico en Walmart..."
                >
                <button class="btn-buscar" onclick="buscarEnWalmart()">🔍 Buscar</button>
            </div>
            <div style="margin-top: 10px; font-size: 0.9em; color: #666;">
                <strong>Sugerencias:</strong> papel higiénico, refrescos
            </div>
        </div>
        
        <div class="info-box">
            <strong id="info-titulo">Todos los productos de Walmart</strong>
            <div id="info-detalle" style="margin-top: 5px; font-size: 0.9em; color: #666;"></div>
            <div id="estadisticas-tienda" class="estadisticas" style="display: none;"></div>
        </div>
        
        <div id="resultados">
            <div class="loading">
                <div class="spinner"></div>
                <p>Cargando productos de Walmart...</p>
            </div>
        </div>
    </div>

    <script>
        let todosLosProductosWalmart = [];
        let busquedaActual = '';

        window.addEventListener('load', function() {
            cargarTodosLosProductosWalmart();
        });
        
        document.getElementById('busqueda-walmart').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                buscarEnWalmart();
            }
        });
        
        function buscarEnWalmart() {
            const termino = document.getElementById('busqueda-walmart').value.trim();
            busquedaActual = termino;
            
            if (termino === '') {
                // Si no hay término, mostrar todos los productos
                mostrarProductosWalmart(todosLosProductosWalmart, 'Todos los productos');
                return;
            }
            
            localStorage.setItem('terminoBusqueda', termino);
            filtrarProductosWalmart(termino);
        }
        
        async function cargarTodosLosProductosWalmart() {
            try {
                // Cargar todos los archivos JSON de Walmart
                const archivos = ['walmart_refrescos.json', 'walmart_papel.json'];
                let todosLosProductos = [];

                for (const archivo of archivos) {
                    const response = await fetch(`../data/${archivo}`);
                    if (response.ok) {
                        const data = await response.json();
                        const productos = procesarJSONWalmart(data);
                        todosLosProductos = todosLosProductos.concat(productos);
                    }
                }

                todosLosProductosWalmart = todosLosProductos;
                mostrarProductosWalmart(todosLosProductos, 'Todos los productos');
                
            } catch (error) {
                document.getElementById('resultados').innerHTML = `
                    <div class="error">
                        <strong>❌ Error:</strong> ${error.message}
                    </div>
                `;
            }
        }

        function procesarJSONWalmart(data) {
            const productos = [];
            
            if (!data.search_results) return productos;

            data.search_results.forEach(bloque => {
                if (!bloque.item || !Array.isArray(bloque.item)) return;
                
                bloque.item.forEach(item => {
                    const precio = extraerPrecio(item.current_price || '');
                    const categoria = detectarCategoria(item.title || '');
                    
                    productos.push({
                        nombre: item.title || 'Sin nombre',
                        precio: precio,
                        precio_antes: item.before_price ? extraerPrecio(item.before_price) : 0,
                        tienda: 'Walmart',
                        categoria: categoria,
                        marca: item.brand || '',
                        imagen: item.thumbnail || '',
                        url: 'https://www.walmart.com.mx' + (item.canonicalUrl || ''),
                        rating: item.rating || 0,
                        reviews: item.review_count || 0,
                        disponibilidad: item.availability_status || '',
                        vendedor: item.seller_name || 'Walmart'
                    });
                });
            });

            return productos;
        }

        function extraerPrecio(precioString) {
            if (!precioString) return 0;
            const match = precioString.match(/\$?(\d+\.?\d*)/);
            return match ? parseFloat(match[1]) : 0;
        }

        function detectarCategoria(nombre) {
            nombre = nombre.toLowerCase();
            if (nombre.includes('papel') || nombre.includes('higienico')) {
                return '🧻 Papel Higiénico';
            }
            if (nombre.includes('refresco') || nombre.includes('coca') || nombre.includes('pepsi')) {
                return '🥤 Refrescos';
            }
            return '🛒 Otros Productos';
        }

        function filtrarProductosWalmart(termino) {
            const terminoLower = termino.toLowerCase();
            const productosFiltrados = todosLosProductosWalmart.filter(producto => 
                producto.nombre.toLowerCase().includes(terminoLower) ||
                producto.categoria.toLowerCase().includes(terminoLower) ||
                producto.marca.toLowerCase().includes(terminoLower)
            );
            
            mostrarProductosWalmart(productosFiltrados, `Resultados para: "${termino}"`);
        }
        
        function mostrarProductosWalmart(productos, titulo) {
            const resultados = document.getElementById('resultados');
            document.getElementById('info-titulo').innerHTML = `<strong>${titulo}</strong>`;
            
            if (!Array.isArray(productos) || productos.length === 0) {
                resultados.innerHTML = '<div class="error">No se encontraron productos disponibles</div>';
                document.getElementById('info-detalle').textContent = '0 productos encontrados';
                document.getElementById('estadisticas-tienda').style.display = 'none';
                return;
            }
            
            // Calcular estadísticas
            const totalProductos = productos.length;
            const categorias = [...new Set(productos.map(p => p.categoria))];
            const precioMin = Math.min(...productos.map(p => p.precio));
            const precioMax = Math.max(...productos.map(p => p.precio));
            const precioPromedio = productos.reduce((sum, p) => sum + p.precio, 0) / totalProductos;
            
            mostrarEstadisticas(totalProductos, categorias.length, precioMin, precioMax, precioPromedio);
            document.getElementById('info-detalle').textContent = `${totalProductos} productos encontrados en ${categorias.length} categorías`;
            
            const productosPorCategoria = {};
            productos.forEach(producto => {
                const categoria = producto.categoria || '🛒 Otros Productos';
                if (!productosPorCategoria[categoria]) {
                    productosPorCategoria[categoria] = [];
                }
                productosPorCategoria[categoria].push(producto);
            });
            
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
                    const rating = prod.rating ? Math.round(prod.rating * 10) / 10 : 0;
                    const estrellas = rating > 0 ? '⭐'.repeat(Math.round(rating)) : '';
                    
                    // Determinar clase de disponibilidad
                    let claseDisponibilidad = 'disponible';
                    let textoDisponibilidad = 'Disponible';
                    
                    const disponibilidadLower = (prod.disponibilidad || '').toLowerCase();
                    if (disponibilidadLower.includes('pocas piezas')) {
                        claseDisponibilidad = 'pocas-piezas';
                        textoDisponibilidad = 'Pocas piezas';
                    } else if (disponibilidadLower.includes('out of stock') || 
                               disponibilidadLower.includes('agotado') || 
                               disponibilidadLower.includes('no disponible')) {
                        claseDisponibilidad = 'sin-stock';
                        textoDisponibilidad = 'Sin stock';
                    } else if (!prod.disponibilidad || prod.disponibilidad === '') {
                        textoDisponibilidad = 'Disponible';
                    } else {
                        textoDisponibilidad = prod.disponibilidad;
                    }
                    
                    html += `
                        <div class="producto-card">
                            ${prod.imagen ? `<img src="${prod.imagen}" alt="${prod.nombre}" class="producto-imagen" onerror="this.style.display='none'">` : ''}
                            ${prod.marca ? `<div class="producto-marca">${prod.marca}</div>` : ''}
                            <div class="producto-nombre">${prod.nombre}</div>
                            <div class="disponibilidad ${claseDisponibilidad}">${textoDisponibilidad}</div>
                            ${prod.precio_antes > 0 ? `<div class="producto-precio-antes">Antes: $${prod.precio_antes.toFixed(2)}</div>` : ''}
                            <div class="producto-precio">$${prod.precio.toFixed(2)}</div>
                            ${rating > 0 ? `<div style="color: #ffa500; font-size: 0.85em; margin-top: 5px;">${estrellas} ${rating} ${prod.reviews > 0 ? `(${prod.reviews})` : ''}</div>` : ''}
                        </div>
                    `;
                });
                
                html += `</div></div>`;
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