<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soriana - ItemWise</title>
    <link rel="stylesheet" href="../../styles/principal.css">
    <link rel="stylesheet" href="../../styles/componentes.css">
    <link rel="stylesheet" href="../../styles/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos para productos del mismo tamaño */
        .recommendations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            align-items: stretch;
        }

        .product-card {
            background-color: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 450px;
        }

        .product-image {
            height: 200px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-title {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--dark);
            font-weight: 600;
            line-height: 1.3;
            min-height: 50px;
            max-height: 50px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            flex-shrink: 0;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 10px;
            flex-shrink: 0;
        }

        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            flex-shrink: 0;
        }

        .product-features {
            margin-bottom: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .product-brand {
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            color: #495057;
            display: inline-block;
            margin-bottom: 8px;
            flex-shrink: 0;
        }

        .product-presentation {
            color: #666;
            font-size: 0.85em;
            margin-top: 5px;
            flex-shrink: 0;
        }

        .availability {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            margin-bottom: 8px;
            display: inline-block;
            flex-shrink: 0;
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

        .product-price-old {
            color: #999;
            font-size: 0.9em;
            text-decoration: line-through;
            flex-shrink: 0;
        }

        .product-store {
            color: #666;
            font-size: 0.9em;
            font-style: italic;
            flex-shrink: 0;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
            flex-shrink: 0;
        }

        .product-image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 2em;
        }

        /* Asegurar que todos los elementos tengan altura consistente */
        .product-card > * {
            box-sizing: border-box;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .recommendations-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }
            
            .product-card {
                min-height: 420px;
            }
            
            .product-image {
                height: 180px;
            }
        }

        @media (max-width: 480px) {
            .recommendations-grid {
                grid-template-columns: 1fr;
            }
            
            .product-card {
                min-height: 400px;
            }
        }

        .search-info {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
            font-size: 0.9em;
        }

        .category-section {
            margin-bottom: 40px;
        }

        .category-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }

        .category-icon {
            font-size: 1.5em;
            margin-right: 10px;
        }

        .category-title {
            font-size: 1.3em;
            font-weight: bold;
            color: #333;
        }

        .category-count {
            background: var(--primary);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="main-header">
        <div class="container">
            <div class="logo">
                <img src="../../img/logo/logo.png" alt="ItemWise Logo" class="logo-img">
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="../../../vista/index.html" class="nav-link">Inicio</a></li>
                    <li><a href="../../../vista/comparador.php" class="nav-link">Comparador</a></li>
                    <li><a href="../../../vista/tiendas.html" class="nav-link active">Tiendas</a></li>
                    <li><a href="../../../vista/recomendaciones.html" class="nav-link">Recomendaciones</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <button class="btn btn-primary" id="open-login-modal">Iniciar Sesión</button>
                <a href="../../../vista/register.html" class="btn btn-outline">Registrarse</a>
            </div>
        </div>
    </header>

    <!-- Hero Section para Soriana -->
    <section class="hero" style="background: linear-gradient(135deg, rgba(236, 161, 21, 0) 0%, rgba(0, 0, 0, 0.81) 100%), url('../../img/tiendas/soriana.jpg') center/cover no-repeat;">
    <div class="container">
        <div class="hero-content" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                <h2>🛒 Soriana - Encuentra los mejores productos</h2>
                <p>Compara precios y características de miles de productos en Soriana</p>
                
                <!-- Search Bar -->
                <div class="search-container">
                    <div class="search-box">
                        <input type="text" id="search-input" placeholder="¿Qué producto buscas en Soriana?">
                        <button id="search-btn" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                    <div class="search-filters">
                        <select id="category-filter">
                            <option value="">Todas las categorías</option>
                            <option value="refrescos">Refrescos y Bebidas</option>
                            <option value="papel">Papel y Desechables</option>
                            <option value="lacteos">Lácteos</option>
                            <option value="galletas">Galletas</option>
                            <option value="arroz">Arroz</option>
                            <option value="limpieza">Limpieza</option>
                        </select>
                        <select id="price-filter">
                            <option value="">Todos los precios</option>
                            <option value="0-50">Menos de $50</option>
                            <option value="50-100">$50 - $100</option>
                            <option value="100-200">$100 - $200</option>
                            <option value="200+">Más de $200</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estadísticas de Soriana -->
    <section class="categories">
        <div class="container">
            <h2>Estadísticas de Soriana</h2>
            <div class="categories-grid" id="soriana-stats">
                <!-- Las estadísticas se cargarán aquí dinámicamente -->
            </div>
        </div>
    </section>

    <!-- Productos de Soriana -->
    <section class="recommendations">
        <div class="container">
            <h2>Productos de Soriana</h2>
            <div id="search-info" class="search-info"></div>
            <div class="recommendations-grid" id="soriana-products">
                <!-- Los productos se cargarán aquí dinámicamente -->
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Cargando productos de Soriana...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>ItemWise</h3>
                    <p>Tu guía inteligente para encontrar los mejores productos al mejor precio.</p>
                </div>
                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="../../../vista/index.html">Inicio</a></li>
                        <li><a href="../../../vista/tiendas.html">Tiendas</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <ul>
                        <li><a href="#">Soporte</a></li>
                        <li><a href="#">Preguntas Frecuentes</a></li>
                        <li><a href="#">Términos y Condiciones</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Síguenos</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 ItemWise. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Modal: Detalle de Producto -->
    <div id="product-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body">
                <!-- Contenido se cargará dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Modal: Inicio de Sesión -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Iniciar sesión</h2>
            <p>Accede a tu cuenta para guardar tus comparaciones favoritas</p>
            <form id="loginForm" action="../../../controlador/engine_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="correo@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember"> Recordar mi sesión
                    </label>
                    <a href="../../../vista/recuperarpassword.html" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Iniciar sesión</button>
                <div class="modal-footer">
                    <p>¿No tienes cuenta? <a href="../../../vista/register.html">Registrate aquí</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // ============ CONFIGURACIÓN DE ARCHIVOS ============
        const ARCHIVOS_SORIANA = [
            'soriana_papel.json',
        ];
        // ============ FIN CONFIGURACIÓN ============

        let todosLosProductosSoriana = [];
        let busquedaActual = '';
        let categoriasDisponibles = new Set();

        function fixSorianaImage(url) {
            if (!url) return '';
            if (url.includes("?")) return url;
            return url + "?sw=300&sh=300&sm=fit";
        }

        window.addEventListener('load', function() {
            cargarTodosLosProductosSoriana();
        });
        
        document.getElementById('search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') buscarEnSoriana();
        });
        
        document.getElementById('search-btn').addEventListener('click', function() {
            buscarEnSoriana();
        });
        
        function buscarEnSoriana() {
            const termino = document.getElementById('search-input').value.trim();
            busquedaActual = termino;
            if (termino === '') {
                mostrarProductosSoriana(todosLosProductosSoriana, 'Todos los productos');
                return;
            }
            localStorage.setItem('terminoBusqueda', termino);
            filtrarProductosSoriana(termino);
        }
        
        async function cargarTodosLosProductosSoriana() {
            try {
                let todosLosProductos = [];
                for (const archivo of ARCHIVOS_SORIANA) {
                    try {
                        console.log('Cargando: ../data/' + archivo);
                        const response = await fetch(`../data/${archivo}?v=${Date.now()}`);
                        if (response.ok) {
                            const text = await response.text();
                            if (!text || text.trim() === '') {
                                console.warn('⚠️ Archivo ' + archivo + ' está vacío');
                                continue;
                            }
                            const data = JSON.parse(text);
                            // Pasamos el nombre del archivo para determinar la categoría
                            const productos = procesarJSONSoriana(data, archivo);
                            todosLosProductos = todosLosProductos.concat(productos);
                            console.log('✅ Cargados ' + productos.length + ' productos de ' + archivo);
                        } else {
                            console.warn('❌ Archivo ' + archivo + ' no encontrado (esto es normal si aún no lo creas)');
                        }
                    } catch (error) {
                        console.error('❌ Error cargando ' + archivo + ':', error);
                    }
                }
                todosLosProductosSoriana = todosLosProductos;
                console.log('📦 Total productos Soriana: ' + todosLosProductosSoriana.length);
                actualizarCategoriasDisponibles();
                if (todosLosProductosSoriana.length === 0) {
                    document.getElementById('soriana-products').innerHTML = '<div class="error"><strong>⚠️ No se cargaron productos de Soriana</strong><p style="margin-top: 10px;">Asegúrate de tener archivos JSON en la carpeta data/</p></div>';
                } else {
                    mostrarProductosSoriana(todosLosProductos, 'Todos los productos');
                    mostrarEstadisticasSoriana();
                }
            } catch (error) {
                document.getElementById('soriana-products').innerHTML = `<div class="error"><strong>❌ Error:</strong> ${error.message}</div>`;
            }
        }

        function obtenerCategoriaPorArchivo(nombreArchivo) {
            // Extraer el nombre sin "soriana_" y sin ".json"
            const nombre = nombreArchivo.replace('soriana_', '').replace('.json', '').toLowerCase();
            
            // Mapeo de nombres de archivo a categorías con íconos
            const mapaCategorias = {
                'refrescos': '🥤 Refrescos y Bebidas',
                'papel': '🧻 Papel y Desechables',
                'lacteos': '🥛 Lácteos',
                'carnes': '🥩 Carnes y Embutidos',
                'arroz': '🌾 Arroz',
                'limpieza': '🧼 Limpieza',
                'galletas': '🍪 Galletas',
                'despensa': '🍝 Despensa'
            };
            
            const categoria = mapaCategorias[nombre] || '🛒 Otros Productos';
            categoriasDisponibles.add(categoria);
            return categoria;
        }

        function procesarJSONSoriana(data, nombreArchivo) {
            const productos = [];
            
            // Determinar categoría según el nombre del archivo
            const categoria = obtenerCategoriaPorArchivo(nombreArchivo);
            
            let lista = [];
            if (Array.isArray(data)) {
                lista = data;
            } else if (data.productos && Array.isArray(data.productos)) {
                lista = data.productos;
            } else if (data.search_results) {
                data.search_results.forEach(bloque => {
                    if (bloque.item && Array.isArray(bloque.item)) {
                        lista = lista.concat(bloque.item);
                    }
                });
            }
            
            lista.forEach(item => {
                const precio = extraerPrecio(item.precio || item.current_price || '');
                if (precio <= 0) return;
                
                const nombre = item.nombre || item.title || 'Sin nombre';
                const precioAntes = item.precio_antes ? extraerPrecio(item.precio_antes) : 
                                   item.before_price ? extraerPrecio(item.before_price) : precio * 1.10;
                
                productos.push({
                    nombre: nombre,
                    precio: precio,
                    precio_antes: precioAntes,
                    tienda: 'Soriana',
                    categoria: categoria, // La categoría viene del nombre del archivo
                    marca: item.marca || item.brand || '',
                    imagen: fixSorianaImage(item.imagen || item.thumbnail || ''),
                    url: item.url || (item.canonicalUrl ? 'https://www.soriana.com' + item.canonicalUrl : '#'),
                    rating: item.rating || 0,
                    reviews: item.reviews || item.review_count || 0,
                    disponibilidad: item.disponibilidad || item.availability_status || 'Disponible',
                    vendedor: item.vendedor || item.seller_name || 'Soriana',
                    presentacion: item.presentacion || ''
                });
            });
            
            return productos;
        }

        function extraerPrecio(precioString) {
            if (!precioString) return 0;
            const match = String(precioString).match(/\$?(\d+\.?\d*)/);
            return match ? parseFloat(match[1]) : 0;
        }

        function actualizarCategoriasDisponibles() {
            // Esta función se puede usar para mostrar categorías disponibles si es necesario
            console.log('Categorías disponibles:', Array.from(categoriasDisponibles));
        }

        function filtrarProductosSoriana(termino) {
            const terminoLower = termino.toLowerCase();
            const productosFiltrados = todosLosProductosSoriana.filter(producto => 
                producto.nombre.toLowerCase().includes(terminoLower) ||
                producto.categoria.toLowerCase().includes(terminoLower) ||
                producto.marca.toLowerCase().includes(terminoLower)
            );
            mostrarProductosSoriana(productosFiltrados, `Resultados para: "${termino}"`);
        }
        
        function mostrarProductosSoriana(productos, titulo) {
            const resultados = document.getElementById('soriana-products');
            const searchInfo = document.getElementById('search-info');
            
            // CORRECCIÓN: Usar el elemento correcto
            if (searchInfo) {
                searchInfo.textContent = `${productos.length} productos encontrados`;
            }
            
            if (!Array.isArray(productos) || productos.length === 0) {
                resultados.innerHTML = '<div class="empty-recommendations"><i class="fas fa-search"></i><p>No se encontraron productos disponibles</p></div>';
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
            
            let html = '';
            
            // Mostrar productos agrupados por categoría
            for (const [categoria, productosCategoria] of Object.entries(productosPorCategoria)) {
                const icono = categoria.split(' ')[0];
                const nombreCategoria = categoria.replace(/^[^\w\s]*\s/, '');
                
                html += `
                    <div class="category-section">
                        <div class="category-header">
                            <span class="category-icon">${icono}</span>
                            <span class="category-title">${nombreCategoria}</span>
                            <span class="category-count">${productosCategoria.length} productos</span>
                        </div>
                        <div class="recommendations-grid">
                `;
                
                productosCategoria.forEach(prod => {
                    const rating = prod.rating ? Math.round(prod.rating * 10) / 10 : 0;
                    const estrellas = rating > 0 ? '⭐'.repeat(Math.round(rating)) : '';
                    
                    let claseDisponibilidad = 'disponible';
                    let textoDisponibilidad = 'Disponible';
                    const disponibilidadLower = (prod.disponibilidad || '').toLowerCase();
                    if (disponibilidadLower.includes('pocas piezas')) {
                        claseDisponibilidad = 'pocas-piezas';
                        textoDisponibilidad = 'Pocas piezas';
                    } else if (disponibilidadLower.includes('out of stock') || disponibilidadLower.includes('agotado') || disponibilidadLower.includes('no disponible')) {
                        claseDisponibilidad = 'sin-stock';
                        textoDisponibilidad = 'Sin stock';
                    }
                    
                    const precioAnteriorHTML = prod.precio_antes > prod.precio ? 
                        `<div class="product-price-old">Antes: $${prod.precio_antes.toFixed(2)}</div>` : '';
                    
                    const ratingHTML = rating > 0 ? 
                        `<div class="product-rating">${estrellas} ${rating} ${prod.reviews > 0 ? `(${prod.reviews})` : ''}</div>` : '';
                    
                    const imagenHTML = prod.imagen ? 
                        `<div class="product-image"><img src="${prod.imagen}" alt="${prod.nombre}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"><div class="product-image-placeholder" style="display:none;"><i class="fas fa-box"></i></div></div>` : 
                        `<div class="product-image"><div class="product-image-placeholder"><i class="fas fa-box"></i></div></div>`;
                    
                    const linkHTML = prod.url && prod.url !== '#' ? 
                        `<div class="product-actions"><a href="${prod.url}" target="_blank" class="btn btn-primary">Ver en Soriana</a></div>` : '';
                    
                    html += `
                        <div class="product-card">
                            ${imagenHTML}
                            <div class="product-info">
                                ${prod.marca ? `<div class="product-brand">${prod.marca}</div>` : ''}
                                <h3 class="product-title">${prod.nombre}</h3>
                                ${prod.presentacion ? `<div class="product-presentation">${prod.presentacion}</div>` : ''}
                                <div class="availability ${claseDisponibilidad}">${textoDisponibilidad}</div>
                                ${precioAnteriorHTML}
                                <div class="product-price">$${prod.precio.toFixed(2)}</div>
                                <div class="product-store">${prod.tienda}</div>
                                ${ratingHTML}
                                ${linkHTML}
                            </div>
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

        function mostrarEstadisticasSoriana() {
            const total = todosLosProductosSoriana.length;
            const categorias = [...new Set(todosLosProductosSoriana.map(p => p.categoria))].length;
            const precioMin = Math.min(...todosLosProductosSoriana.map(p => p.precio));
            const precioMax = Math.max(...todosLosProductosSoriana.map(p => p.precio));
            const precioPromedio = todosLosProductosSoriana.reduce((sum, p) => sum + p.precio, 0) / total;
            
            const statsHTML = `
                <div class="category-card">
                    <i class="fas fa-boxes" style="color:#ff3c38;"></i>
                    <h3>${total}</h3>
                    <p>Total Productos</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-tags" style="color:#ff3c38;"></i>
                    <h3>${categorias}</h3>
                    <p>Categorías</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-dollar-sign" style="color:#ff3c38;"></i>
                    <h3>$${precioMin.toFixed(2)}</h3>
                    <p>Precio Mínimo</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-dollar-sign" style="color:#ff3c38;"></i>
                    <h3>$${precioMax.toFixed(2)}</h3>
                    <p>Precio Máximo</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-chart-line" style="color:#ff3c38;"></i>
                    <h3>$${precioPromedio.toFixed(2)}</h3>
                    <p>Precio Promedio</p>
                </div>
            `;
            
            document.getElementById('soriana-stats').innerHTML = statsHTML;
        }

        // Funcionalidad de los modales
        document.addEventListener('DOMContentLoaded', function() {
            // Modal de login
            const loginModal = document.getElementById('login-modal');
            const openLoginModal = document.getElementById('open-login-modal');
            const closeButtons = document.querySelectorAll('.close');

            if (openLoginModal) {
                openLoginModal.addEventListener('click', function() {
                    loginModal.style.display = 'block';
                });
            }

            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.modal').style.display = 'none';
                });
            });

            window.addEventListener('click', function(event) {
                if (event.target.classList.contains('modal')) {
                    event.target.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>