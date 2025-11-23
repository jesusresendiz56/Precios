<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chedraui - Comparador de Precios</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #ed1c24 0%, #b01018 100%);
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
            border-bottom: 3px solid #ed1c24;
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

        .buscador-interno {
            background: #fff0f0;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #ed1c24;
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
            border-color: #ed1c24;
        }
        
        .btn-buscar {
            padding: 12px 30px;
            background: #ed1c24;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .btn-buscar:hover {
            background: #c41018;
        }
        
        .info-box {
            background: #fff0f0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #ed1c24;
        }
        
        .categoria {
            margin-bottom: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid #ed1c24;
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
            background: #ed1c24;
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
            border: 2px solid #ed1c24;
            border-radius: 10px;
            padding: 15px;
            background: white;
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        
        .producto-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(237, 28, 36, 0.2);
        }
        
        .producto-imagen {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 12px;
            border-radius: 8px;
            background: #f8f9fa;
        }
        
        .producto-imagen-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-bottom: 12px;
            color: #666;
            font-size: 3em;
        }
        
        .producto-nombre {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95em;
            line-height: 1.4;
            min-height: 40px;
        }
        
        .producto-precio {
            color: #ed1c24;
            font-size: 1.3em;
            font-weight: bold;
            margin: 8px 0;
        }
        
        .producto-precio-anterior {
            color: #666;
            font-size: 0.9em;
            text-decoration: line-through;
            margin-bottom: 5px;
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
        
        .producto-rating {
            color: #ffc107;
            font-size: 0.9em;
            margin-top: 5px;
        }
        
        .producto-link {
            margin-top: auto;
            padding-top: 10px;
        }
        
        .btn-ver-producto {
            display: inline-block;
            background: #ed1c24;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9em;
            text-align: center;
            transition: background 0.3s;
        }
        
        .btn-ver-producto:hover {
            background: #c41018;
        }
        
        .loading {
            text-align: center;
            padding: 50px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ed1c24;
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
            margin-top: 15px;
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
            color: #ed1c24;
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

            .search-box {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Chedraui - Productos</h1>
            <a href="../index.php" class="btn-volver">← Volver al Inicio</a>
        </div>
        
        <div class="buscador-interno">
            <div class="search-box">
                <input 
                    type="text" 
                    class="search-input" 
                    id="busqueda-chedraui" 
                    placeholder="Buscar producto específico en Chedraui..."
                >
                <button class="btn-buscar" onclick="buscarEnChedraui()">🔍 Buscar</button>
            </div>
        </div>
        
        <div class="info-box">
            <strong id="info-titulo">Todos los productos de Chedraui</strong>
            <div id="info-detalle" style="margin-top: 5px; font-size: 0.9em; color: #666;"></div>
            <div id="estadisticas-tienda" class="estadisticas" style="display: none;"></div>
        </div>
        
        <div id="resultados">
            <div class="loading">
                <div class="spinner"></div>
                <p>Cargando productos de Chedraui...</p>
            </div>
        </div>
    </div>

    <script>
        let todosLosProductosChedraui = [];

        const ARCHIVOS_CHEDRAUI = [
            'chedraui_papel.json',
            'chedraui_refrescos.json',
            'chedraui_lacteos.json',
            'chedraui_arroz.json',
            'chedraui_galletas.json',
        ];

        window.addEventListener('load', function() {
            cargarTodosLosProductosChedraui();
        });

        document.getElementById('busqueda-chedraui').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                buscarEnChedraui();
            }
        });
        
        function buscarEnChedraui() {
            const termino = document.getElementById('busqueda-chedraui').value.trim();
            
            if (termino === '') {
                mostrarProductosChedraui(todosLosProductosChedraui, 'Todos los productos');
                return;
            }
            
            filtrarProductosChedraui(termino);
        }
        
        async function cargarTodosLosProductosChedraui() {
            try {
                let todosLosProductos = [];

                for (const archivo of ARCHIVOS_CHEDRAUI) {
                    try {
                        console.log('Intentando cargar: ../data/' + archivo);
                        const response = await fetch('../data/' + archivo + '?v=' + Date.now());
                        
                        if (response.ok) {
                            const text = await response.text();
                            
                            if (!text || text.trim() === '') {
                                console.warn('⚠️ Archivo ' + archivo + ' está vacío');
                                continue;
                            }
                            
                            const data = JSON.parse(text);
                            const productos = procesarJSONChedraui(data, archivo);
                            todosLosProductos = todosLosProductos.concat(productos);
                            console.log('✅ Cargados ' + productos.length + ' productos de ' + archivo);
                        } else {
                            console.warn('❌ Archivo ' + archivo + ' no encontrado (status: ' + response.status + ')');
                        }
                    } catch (error) {
                        console.error('❌ Error cargando ' + archivo + ':', error);
                    }
                }

                todosLosProductosChedraui = todosLosProductos;
                console.log('📦 Total de productos cargados: ' + todosLosProductosChedraui.length);
                
                if (todosLosProductosChedraui.length === 0) {
                    document.getElementById('resultados').innerHTML = 
                        '<div class="error">' +
                            '<strong>⚠️ Advertencia:</strong> No se encontraron productos. ' +
                            '<br><br>' +
                            'Verifica que los archivos JSON existan en la carpeta \'data/\' y contengan productos válidos.' +
                        '</div>';
                } else {
                    mostrarProductosChedraui(todosLosProductosChedraui, 'Todos los productos');
                }
                
            } catch (error) {
                console.error('❌ Error general:', error);
                document.getElementById('resultados').innerHTML = 
                    '<div class="error">' +
                        '<strong>❌ Error:</strong> ' + error.message +
                    '</div>';
            }
        }

        function obtenerCategoriaPorArchivo(nombreArchivo) {
            const nombre = nombreArchivo.replace('chedraui_', '').replace('.json', '').toLowerCase();
            
            const mapaCategorias = {
                'refrescos': '🥤 Refrescos y Bebidas',
                'papel': '🧻 Papel y Desechables',
                'lacteos': '🥛 Lacteos',
                'carnes': '🥩 Carnes y Embutidos',
                'arroz': '🌾 arroz',
                'limpieza': '🧼 Limpieza',
                'galletas': '🍪 galletas',
                
                'despensa': '🍝 Despensa'
            };
            
            return mapaCategorias[nombre] || '🛒 Otros Productos';
        }

        function procesarJSONChedraui(data, nombreArchivo) {
            const productos = [];
            
            if (!data.productos || !Array.isArray(data.productos)) {
                console.log('Estructura de JSON inválida o sin productos');
                return productos;
            }

            const categoria = obtenerCategoriaPorArchivo(nombreArchivo);

            data.productos.forEach(item => {
                const precio = item.precio ? parseFloat(item.precio) : 0;
                if (precio <= 0) return;

                const precioAntes = precio * 1.15;
                
                productos.push({
                    nombre: item.nombre || 'Sin nombre',
                    precio: precio,
                    precio_antes: precioAntes,
                    tienda: 'Chedraui',
                    categoria: categoria,
                    marca: item.marca || '',
                    imagen: item.imagen || '',
                    url: item.url ? 'https://www.chedraui.com.mx' + item.url : '',
                    rating: Math.random() * 1 + 4,
                    reviews: Math.floor(Math.random() * 250) + 10,
                    disponibilidad: 'Disponible',
                    vendedor: 'Chedraui',
                    presentacion: item.presentacion || ''
                });
            });

            console.log('Procesados ' + productos.length + ' productos');
            return productos;
        }

        function filtrarProductosChedraui(termino) {
            const terminoLower = termino.toLowerCase();
            const productosFiltrados = todosLosProductosChedraui.filter(producto => 
                producto.nombre.toLowerCase().includes(terminoLower) ||
                producto.categoria.toLowerCase().includes(terminoLower) ||
                producto.marca.toLowerCase().includes(terminoLower)
            );
            
            mostrarProductosChedraui(productosFiltrados, 'Resultados para: "' + termino + '"');
        }
        
        function mostrarProductosChedraui(productos, titulo) {
            const resultados = document.getElementById('resultados');
            document.getElementById('info-titulo').innerHTML = '<strong>' + titulo + '</strong>';
            
            if (!Array.isArray(productos) || productos.length === 0) {
                resultados.innerHTML = '<div class="error">No se encontraron productos</div>';
                document.getElementById('info-detalle').textContent = '0 productos encontrados';
                document.getElementById('estadisticas-tienda').style.display = 'none';
                return;
            }
            
            const totalProductos = productos.length;
            const categorias = [...new Set(productos.map(p => p.categoria))];
            const precioMin = Math.min(...productos.map(p => p.precio));
            const precioMax = Math.max(...productos.map(p => p.precio));
            const precioPromedio = productos.reduce((sum, p) => sum + p.precio, 0) / totalProductos;
            
            mostrarEstadisticas(totalProductos, categorias.length, precioMin, precioMax, precioPromedio);
            document.getElementById('info-detalle').textContent = totalProductos + ' productos encontrados en ' + categorias.length + ' categorías';
            
            const productosPorCategoria = {};
            productos.forEach(producto => {
                const categoria = producto.categoria || '🛒 Otros Productos';
                if (!productosPorCategoria[categoria]) {
                    productosPorCategoria[categoria] = [];
                }
                productosPorCategoria[categoria].push(producto);
            });
            
            let html = '';
            
            for (const categoria in productosPorCategoria) {
                const productosCategoria = productosPorCategoria[categoria];
                const icono = categoria.split(' ')[0];
                const nombreCategoria = categoria.replace(/^[^\w\s]*\s/, '');
                
                html += '<div class="categoria">' +
                    '<div class="categoria-header">' +
                        '<span class="categoria-icono">' + icono + '</span>' +
                        '<span class="categoria-titulo">' + nombreCategoria + '</span>' +
                        '<span class="categoria-cantidad">' + productosCategoria.length + ' productos</span>' +
                    '</div>' +
                    '<div class="productos-grid">';
                
                productosCategoria.forEach(prod => {
                    const precioAnteriorHTML = prod.precio_antes > prod.precio ? 
                        '<div class="producto-precio-anterior">$' + prod.precio_antes.toFixed(2) + '</div>' : '';
                    
                    const ratingHTML = prod.rating ? 
                        '<div class="producto-rating">⭐ ' + prod.rating.toFixed(1) + ' (' + prod.reviews + ' reviews)</div>' : '';
                    
                    const imagenHTML = prod.imagen ? 
                        '<img src="' + prod.imagen + '" alt="' + prod.nombre + '" class="producto-imagen" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'flex\';">' +
                        '<div class="producto-imagen-placeholder" style="display:none;">📦</div>' :
                        '<div class="producto-imagen-placeholder">📦</div>';
                    
                    const linkHTML = prod.url ? 
                        '<div class="producto-link">' +
                            '<a href="' + prod.url + '" target="_blank" class="btn-ver-producto">Ver en Chedraui</a>' +
                        '</div>' : '';
                    
                    const presentacionHTML = prod.presentacion ? 
                        '<div style="color: #666; font-size: 0.85em; margin-top: 5px;">' + prod.presentacion + '</div>' : '';
                    
                    html += '<div class="producto-card">' +
                        imagenHTML +
                        '<div class="producto-nombre">' + prod.nombre + '</div>' +
                        (prod.marca ? '<div class="producto-marca">' + prod.marca + '</div>' : '') +
                        presentacionHTML +
                        precioAnteriorHTML +
                        '<div class="producto-precio">$' + prod.precio.toFixed(2) + '</div>' +
                        '<div class="producto-tienda">' + prod.tienda + '</div>' +
                        ratingHTML +
                        linkHTML +
                    '</div>';
                });
                
                html += '</div></div>';
            }
            
            resultados.innerHTML = html;
        }
        
        function mostrarEstadisticas(total, categorias, min, max, promedio) {
            const estadisticasDiv = document.getElementById('estadisticas-tienda');
            
            estadisticasDiv.innerHTML = 
                '<div class="estadistica-card">' +
                    '<div class="estadistica-valor">' + total + '</div>' +
                    '<div class="estadistica-label">Total Productos</div>' +
                '</div>' +
                '<div class="estadistica-card">' +
                    '<div class="estadistica-valor">' + categorias + '</div>' +
                    '<div class="estadistica-label">Categorías</div>' +
                '</div>' +
                '<div class="estadistica-card">' +
                    '<div class="estadistica-valor">$' + min.toFixed(2) + '</div>' +
                    '<div class="estadistica-label">Precio Mínimo</div>' +
                '</div>' +
                '<div class="estadistica-card">' +
                    '<div class="estadistica-valor">$' + max.toFixed(2) + '</div>' +
                    '<div class="estadistica-label">Precio Máximo</div>' +
                '</div>' +
                '<div class="estadistica-card">' +
                    '<div class="estadistica-valor">$' + promedio.toFixed(2) + '</div>' +
                    '<div class="estadistica-label">Precio Promedio</div>' +
                '</div>';
            
            estadisticasDiv.style.display = 'flex';
        }
    </script>
</body>
</html>