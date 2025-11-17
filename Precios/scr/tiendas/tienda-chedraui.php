<?php
// Opcional: si necesitas datos dinámicos desde PHP, aquí los defines
$termino = $_GET['q'] ?? 'papel higiénico';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chedraui - ItemWise</title>
    <link rel="stylesheet" href="../../scr/styles/principal.css">
    <link rel="stylesheet" href="../../scr/styles/componentes.css">
    <link rel="stylesheet" href="../styles/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos específicos para esta tienda — ligeros y compatibles */
        .store-banner {
            background: linear-gradient(135deg, #ed1c24, #f0544c);
            color: white;
            padding: 30px 20px;
            border-radius: 12px;
            text-align: center;
            margin: 20px 0 30px;
            box-shadow: 0 4px 12px rgba(237, 28, 36, 0.2);
        }
        .store-banner h1 {
            font-size: 2.2rem;  
            padding: 29px;
        }
        .store-banner p {
            opacity: 0.95;
            font-size: 1.1rem;
            padding: auto;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #ed1c24;
        }
        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }
        .producto-card {
            border: 1px solid #eee;
            border-radius: 10px;
            overflow: hidden;
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .producto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(237, 28, 36, 0.15);
        }
        .producto-imagen {
            height: 160px;
            background: #fafafa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }
        .producto-imagen img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .producto-info {
            padding: 15px;
        }
        .producto-nombre {
            font-weight: 600;
            font-size: 1.05rem;
            color: #333;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .producto-marca {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 6px;
        }
        .producto-precio {
            color: #ed1c24;
            font-weight: bold;
            font-size: 1.3rem;
            margin: 8px 0;
        }
        .estadisticas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin: 20px 0;
        }
        .estadistica-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #eee;
        }
        .estadistica-valor {
            font-size: 1.4rem;
            font-weight: bold;
            color: #ed1c24;
        }
        .estadistica-label {
            font-size: 0.85rem;
            color: #666;
        }
        .categoria-section {
            margin-bottom: 40px;
        }
        .categoria-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ed1c24;
        }
        .categoria-header i {
            color: #ed1c24;
        }
        .categoria-header h2 {
            font-size: 1.5rem;
            color: #333;
        }
        .categoria-count {
            background: #ed1c24;
            color: white;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
        }
        .loading {
            text-align: center;
            padding: 60px 20px;
        }
        .container{
            height: 4em;
        }
        .container2{
            height: 4em;
            margin: 3em ;
            padding: 3em;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ed1c24;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Header igual que en index.html -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="../img/logo/logo.png" alt="ItemWise Logo" class="logo-img">
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="../../vista/index.html" class="nav-link">Inicio</a></li>
                    <li><a href="../../vista/tiendas.html" class="nav-link">Tiendas</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <button class="btn btn-primary" id="open-login-modal">Iniciar Sesión</button>
                <a href="../../vista/register.html" class="btn btn-outline">Registrarse</a>
            </div>
        </div>
    </header>

    <main class="container2">
        <!-- Banner de tienda -->
        <div class="store-banner">
            <i class="fas fa-shopping-cart" style="font-size: 2.5rem; margin-bottom: 15px;"></i>
            <h1>🛒 Chedraui</h1>
            <p>Alimentos, hogar, belleza y más — al mejor precio</p>
        </div>

        <!-- Info & estadísticas -->
        <div class="info-box">
            <strong>Producto buscado:</strong> <span id="producto-buscado"><?= htmlspecialchars($termino) ?></span>
            <div id="estadisticas-tienda" class="estadisticas" style="display: none;"></div>
        </div>

        <!-- Resultados -->
        <div id="resultados">
            <div class="loading">
                <div class="spinner"></div>
                <p>Cargando productos de Chedraui...</p>
            </div>
        </div>
    </main>

    <!-- Modal de login (reutilizado de index.html) -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Iniciar sesión</h2>
            <p>Accede para guardar comparaciones y ver ofertas personalizadas</p>
            <form id="loginForm" action="../../controlador/engine_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="tu@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember"> Recordar sesión
                    </label>
                    <a href="../../vista/recuperarpassword.html">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Iniciar sesión</button>
                <div class="modal-footer">
                    <p>¿No tienes cuenta? <a href="../../vista/register.html">Regístrate aquí</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/principal.js"></script>
    <script>
        window.addEventListener('load', () => {
            const termino = <?= json_encode($termino) ?>;
            document.getElementById('producto-buscado').textContent = termino;
            cargarProductosChedraui(termino);
        });

        async function cargarProductosChedraui(termino) {
            try {
                const formData = new FormData();
                formData.append('buscar', '1');
                formData.append('termino', termino);
                const response = await fetch('../tiendas/scraper.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                mostrarProductos(data.chedraui || []);
            } catch (err) {
                document.getElementById('resultados').innerHTML = `
                    <div class="alert alert-error">
                        <img src="../img/logo/logo.png" alt="ItemWise Logo" class="logo-img">
                        Error al cargar productos.
                    </div>
                `;
            }
        }

        function mostrarProductos(productos) {
            const cont = document.getElementById('resultados');
            if (!productos.length) {
                cont.innerHTML = '<p class="text-center">No se encontraron productos.</p>';
                return;
            }

            // Agrupar por categoría
            const grupos = {};
            productos.forEach(p => {
                const cat = p.categoria || 'Otros productos';
                grupos[cat] = grupos[cat] || [];
                grupos[cat].push(p);
            });

            // Estadísticas
            const total = productos.length;
            const cats = Object.keys(grupos).length;
            const min = Math.min(...productos.map(p => p.precio));
            const max = Math.max(...productos.map(p => p.precio));
            const avg = productos.reduce((s, p) => s + p.precio, 0) / total;
            mostrarEstadisticas(total, cats, min, max, avg);

            // HTML
            let html = '';
            for (const [cat, items] of Object.entries(grupos)) {
                html += `
                <div class="categoria-section">
                    <div class="categoria-header">
                        <img src="../img/logo/logo.png" alt="ItemWise Logo" class="logo-img">
                        <h2>${cat}</h2>
                        <span class="categoria-count">${items.length}</span>
                    </div>
                    <div class="productos-grid">
                `;
                items.forEach(p => {
                    html += `
                    <div class="producto-card">
                        <div class="producto-imagen">
                            <img src="${p.imagen || 'https://via.placeholder.com/200x200?text=Sin+imagen'}"
                            alt="${p.nombre}" onerror="this.src='https://via.placeholder.com/200x200?text=Sin+imagen'">
                        </div>
                        <div class="producto-info">
                            <div class="producto-marca">${p.marca || '—'}</div>
                            <div class="producto-nombre">${p.nombre}</div>
                            <div class="producto-precio">$${p.precio.toFixed(2)}</div>
                            <button class="btn btn-outline btn-sm">
                                <img src="../img/logo/logo.png" alt="ItemWise Logo" class="logo-img"> Comparar
                            </button>
                        </div>
                    </div>
                    `;
                });
                html += `</div></div>`;
            }
            cont.innerHTML = html;
        }

        function mostrarEstadisticas(total, cats, min, max, avg) {
            const el = document.getElementById('estadisticas-tienda');
            el.innerHTML = `
                <div class="estadistica-card">
                    <div class="estadistica-valor">${total}</div>
                    <div class="estadistica-label">Productos</div>
                </div>
                <div class="estadistica-card">
                    <div class="estadistica-valor">${cats}</div>
                    <div class="estadistica-label">Categorías</div>
                </div>
                <div class="estadistica-card">
                    <div class="estadistica-valor">$${min.toFixed(2)}</div>
                    <div class="estadistica-label">Mín</div>
                </div>
                <div class="estadistica-card">
                    <div class="estadistica-valor">$${avg.toFixed(2)}</div>
                    <div class="estadistica-label">Prom</div>
                </div>
            `;
            el.style.display = 'grid';
        }

        // Soporte básico para modal (si principal.js no lo carga aquí)
        document.getElementById('open-login-modal')?.addEventListener('click', () => {
            document.getElementById('login-modal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        });
        document.querySelector('#login-modal .close')?.addEventListener('click', () => {
            document.getElementById('login-modal').style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    </script>
</body>
</html>