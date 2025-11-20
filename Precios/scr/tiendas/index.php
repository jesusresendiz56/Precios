<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛒 Comparador de Precios - México</title>
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
        }
        
        /* Header con buscador */
        .header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5em;
        }
        
        .buscador {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .search-input {
            flex: 1;
            padding: 15px 20px;
            font-size: 1.1em;
            border: 2px solid #ddd;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-buscar {
            padding: 15px 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-buscar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .sugerencias {
            text-align: center;
            color: #666;
            font-size: 0.9em;
        }
        
        .sugerencias span {
            display: inline-block;
            background: #f0f0f0;
            padding: 5px 12px;
            margin: 5px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .sugerencias span:hover {
            background: #667eea;
            color: white;
        }
        
        /* Sección de tiendas */
        .tiendas-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .section-title {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .tiendas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .tienda-card {
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .tienda-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.3) 100%);
            z-index: 1;
        }
        
        .tienda-card > * {
            position: relative;
            z-index: 2;
        }
        
        .tienda-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .walmart-card {
            background: linear-gradient(135deg, #0071ce 0%, #004c91 100%);
        }
        
        .chedraui-card {
            background: linear-gradient(135deg, #ed1c24 0%, #b01018 100%);
        }
        
        .soriana-card {
            background: linear-gradient(135deg, #00a94f 0%, #007a38 100%);
        }
        
        .comparar-card {
            background: linear-gradient(135deg, #ff6b00 0%, #cc5500 100%);
        }
        
        .tienda-icono {
            font-size: 3em;
            margin-bottom: 10px;
        }
        
        .tienda-nombre {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .tienda-descripcion {
            font-size: 0.9em;
            opacity: 0.9;
        }
        
        /* Categorías populares */
        .categorias-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .categorias-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .categoria-btn {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border: none;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .categoria-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .categoria-icono {
            font-size: 2em;
            display: block;
            margin-bottom: 8px;
        }
        
        .categoria-nombre {
            font-weight: bold;
            font-size: 1em;
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8em;
            }
            
            .search-box {
                flex-direction: column;
            }
            
            .tiendas-grid, .categorias-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header con buscador -->
        <div class="header">
            <h1>🛒 Comparador de Precios</h1>
            <div class="buscador">
                <div class="search-box">
                    <input 
                        type="text" 
                        class="search-input" 
                        id="busqueda" 
                        placeholder="¿Qué producto buscas? Ej: leche, arroz, shampoo..."
                    >
                    <button class="btn-buscar" onclick="buscarEnTodasTiendas()">
                        🔍 Buscar
                    </button>
                </div>
                <div class="sugerencias">
                    <strong>Sugerencias:</strong>
                    <span onclick="buscarRapido('papel higiénico')">🧻 Papel</span>
                    <span onclick="buscarRapido('leche')">🥛 Leche</span>
                    <span onclick="buscarRapido('arroz')">🍚 Arroz</span>
                    <span onclick="buscarRapido('detergente')">🧼 Detergente</span>
                    <span onclick="buscarRapido('aceite')">🫗 Aceite</span>
                </div>
            </div>
        </div>
        
        <!-- Sección de tiendas -->
        <div class="tiendas-section">
            <h2 class="section-title">🏪 Explora por Tienda</h2>
            <div class="tiendas-grid">
                <a href="pages/tienda-walmart.php" class="tienda-card walmart-card">
                    <div class="tienda-icono">🟦</div>
                    <div class="tienda-nombre">Walmart</div>
                    <div class="tienda-descripcion">Ver todos los productos de Walmart</div>
                </a>
                
                <a href="pages/tienda-chedraui.php" class="tienda-card chedraui-card">
                    <div class="tienda-icono">🟥</div>
                    <div class="tienda-nombre">Chedraui</div>
                    <div class="tienda-descripcion">Ver todos los productos de Chedraui</div>
                </a>
                
                <a href="pages/tienda-soriana.php" class="tienda-card soriana-card">
                    <div class="tienda-icono">🟩</div>
                    <div class="tienda-nombre">Soriana</div>
                    <div class="tienda-descripcion">Ver todos los productos de Soriana</div>
                </a>
                
                <a href="pages/comparar-todos.php" class="tienda-card comparar-card">
                    <div class="tienda-icono">⚖️</div>
                    <div class="tienda-nombre">Comparar Todas</div>
                    <div class="tienda-descripcion">Compara precios entre todas las tiendas</div>
                </a>
            </div>
        </div>
        
        <!-- Categorías populares -->
        <div class="categorias-section">
            <h2 class="section-title">📦 Categorías Populares</h2>
            <div class="categorias-grid">
                <button class="categoria-btn" onclick="buscarRapido('papel higiénico')">
                    <span class="categoria-icono">🧻</span>
                    <span class="categoria-nombre">Papel Higiénico</span>
                </button>
                
                <button class="categoria-btn" onclick="buscarRapido('leche')">
                    <span class="categoria-icono">🥛</span>
                    <span class="categoria-nombre">Lácteos</span>
                </button>
                
                <button class="categoria-btn" onclick="buscarRapido('arroz')">
                    <span class="categoria-icono">🍚</span>
                    <span class="categoria-nombre">Despensa</span>
                </button>
                
                <button class="categoria-btn" onclick="buscarRapido('detergente')">
                    <span class="categoria-icono">🧼</span>
                    <span class="categoria-nombre">Limpieza</span>
                </button>
                
                <button class="categoria-btn" onclick="buscarRapido('shampoo')">
                    <span class="categoria-icono">🧴</span>
                    <span class="categoria-nombre">Higiene Personal</span>
                </button>
                
                <button class="categoria-btn" onclick="buscarRapido('refresco')">
                    <span class="categoria-icono">🥤</span>
                    <span class="categoria-nombre">Bebidas</span>
                </button>
                
                <button class="categoria-btn" onclick="buscarRapido('galletas')">
                    <span class="categoria-icono">🍪</span>
                    <span class="categoria-nombre">Botanas</span>
                </button>
                
                <button class="categoria-btn" onclick="buscarRapido('atún')">
                    <span class="categoria-icono">🥫</span>
                    <span class="categoria-nombre">Enlatados</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Buscar cuando se presiona Enter
        document.getElementById('busqueda').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                buscarEnTodasTiendas();
            }
        });
        
        function buscarEnTodasTiendas() {
            const termino = document.getElementById('busqueda').value.trim();
            
            if (termino === '') {
                alert('⚠️ Por favor ingresa un producto a buscar');
                return;
            }
            
            // Guardar el término en localStorage
            localStorage.setItem('terminoBusqueda', termino);
            
            // Redirigir a la página de comparación
            window.location.href = 'pages/comparar-todos.php';
        }
        
        function buscarRapido(termino) {
            document.getElementById('busqueda').value = termino;
            buscarEnTodasTiendas();
        }
    </script>
</body>
</html>