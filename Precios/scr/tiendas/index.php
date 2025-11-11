<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Precios - Tiendas</title>
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
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.2em;
        }
        
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        input[type="text"] {
            flex: 1;
            min-width: 300px;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .btn-buscar {
            padding: 12px 25px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        
        .btn-buscar:hover {
            background: #5568d3;
        }
        
        .tiendas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .tienda-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 3px solid transparent;
        }
        
        .tienda-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .tienda-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        
        .tienda-card h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .tienda-card p {
            color: #666;
            margin-bottom: 15px;
        }
        
        .btn-tienda {
            padding: 10px 20px;
            background: #333;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .walmart-card {
            border-color: #0071ce;
        }
        
        .walmart-card .btn-tienda {
            background: #0071ce;
        }
        
        .chedraui-card {
            border-color: #ed1c24;
        }
        
        .chedraui-card .btn-tienda {
            background: #ed1c24;
        }
        
        .soriana-card {
            border-color: #00a94f;
        }
        
        .soriana-card .btn-tienda {
            background: #00a94f;
        }
        
        .comparar-card {
            border-color: #ff6b00;
            background: linear-gradient(135deg, #fff, #fff8f0);
        }
        
        .comparar-card .btn-tienda {
            background: #ff6b00;
        }
        
        .loading {
            text-align: center;
            padding: 30px;
            display: none;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
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
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .search-box {
                flex-direction: column;
            }
            
            input[type="text"] {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛒 Comparador de Precios</h1>
        
        <div class="search-box">
            <input 
                type="text" 
                id="termino" 
                placeholder="¿Qué producto estás buscando? Ejemplo: leche, pan, arroz..."
                value="papel higienico"
            >
            <button class="btn-buscar" onclick="buscarEnTodas()">Buscar en Todas</button>
        </div>
        
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Buscando productos...</p>
        </div>
        
        <div class="tiendas-grid">
            <!-- Walmart -->
            <div class="tienda-card walmart-card" onclick="irATienda('walmart')">
                <div class="tienda-icon">🏪</div>
                <h2>Walmart</h2>
                <p>Busca productos específicos en Walmart</p>
                <button class="btn-tienda" onclick="event.stopPropagation(); irATienda('walmart')">
                    Ver Walmart
                </button>
            </div>
            
            <!-- Chedraui -->
            <div class="tienda-card chedraui-card" onclick="irATienda('chedraui')">
                <div class="tienda-icon">🛒</div>
                <h2>Chedraui</h2>
                <p>Explora productos en Chedraui</p>
                <button class="btn-tienda" onclick="event.stopPropagation(); irATienda('chedraui')">
                    Ver Chedraui
                </button>
            </div>
            
            <!-- Soriana -->
            <div class="tienda-card soriana-card" onclick="irATienda('soriana')">
                <div class="tienda-icon">🏬</div>
                <h2>Soriana</h2>
                <p>Encuentra productos en Soriana</p>
                <button class="btn-tienda" onclick="event.stopPropagation(); irATienda('soriana')">
                    Ver Soriana
                </button>
            </div>
            
            <!-- Comparar Todos -->
            <div class="tienda-card comparar-card" onclick="compararTodos()">
                <div class="tienda-icon">⚖️</div>
                <h2>Comparar Todos</h2>
                <p>Compara precios entre todas las tiendas</p>
                <button class="btn-tienda" onclick="event.stopPropagation(); compararTodos()">
                    Comparar Ahora
                </button>
            </div>
        </div>
    </div>

    <script>
        function buscarEnTodas() {
            const termino = document.getElementById('termino').value.trim();
            
            if (!termino) {
                alert('Por favor ingresa un producto para buscar');
                return;
            }
            
            // Guardar término en localStorage para las otras páginas
            localStorage.setItem('terminoBusqueda', termino);
            
            // Ir directamente a comparar todos
            compararTodos();
        }
        
        function irATienda(tienda) {
            const termino = document.getElementById('termino').value.trim();
            
            if (!termino) {
                alert('Por favor ingresa un producto para buscar');
                return;
            }
            
            // Guardar término en localStorage
            localStorage.setItem('terminoBusqueda', termino);
            
            // ACTUALIZADO: Redirigir a la página de la tienda en la carpeta pages/
            window.location.href = `pages/tienda-${tienda}.php`;
        }
        
        function compararTodos() {
            const termino = document.getElementById('termino').value.trim();
            
            if (!termino) {
                alert('Por favor ingresa un producto para buscar');
                return;
            }
            
            // Guardar término en localStorage
            localStorage.setItem('terminoBusqueda', termino);
            
            // ACTUALIZADO: Redirigir a la página de comparación en la carpeta pages/
            window.location.href = 'pages/comparar-todos.php';
        }
        
        // Cargar término guardado si existe
        window.addEventListener('load', function() {
            const terminoGuardado = localStorage.getItem('terminoBusqueda');
            if (terminoGuardado) {
                document.getElementById('termino').value = terminoGuardado;
            }
        });
    </script>
</body>
</html>