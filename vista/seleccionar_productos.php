<?php
// NO iniciar sesión aquí porque ya está iniciada en ComparadorPersonalizado.php

// Validar que existan las variables de sesión necesarias
if (!isset($_SESSION['categoria']) || !isset($_SESSION['comparacion'])) {
    header('Location: ../vista/comparador.php');
    exit();
}

// Cargar los productos disponibles para mostrarlos en el selector
$categoria = $_SESSION['categoria'];
$comparacion = $_SESSION['comparacion'];
$dataPath = __DIR__ . '/../scr/tiendas/data/';

$productosDisponibles = [];

// Cargar productos de Walmart
if ($comparacion === 'walmart_chedraui' || $comparacion === 'solo_walmart') {
    $archivoWalmart = $dataPath . "walmart_{$categoria}.json";
    if (file_exists($archivoWalmart)) {
        $dataWalmart = json_decode(file_get_contents($archivoWalmart), true);
        
        // Normalizar productos de Walmart
        if (isset($dataWalmart['search_results'])) {
            foreach ($dataWalmart['search_results'] as $resultado) {
                if (isset($resultado['item'])) {
                    foreach ($resultado['item'] as $item) {
                        if (isset($item['title']) && isset($item['current_price'])) {
                            $precio = is_string($item['current_price']) 
                                ? floatval(preg_replace('/[^0-9.]/', '', $item['current_price']))
                                : floatval($item['current_price']);
                            
                            if ($precio > 0) {
                                $productosDisponibles[] = [
                                    'nombre' => $item['title'],
                                    'precio' => $precio,
                                    'tienda' => 'Walmart',
                                    'imagen' => $item['thumbnail'] ?? ''
                                ];
                            }
                        }
                    }
                }
            }
        }
    }
}

// Cargar productos de Chedraui
if ($comparacion === 'walmart_chedraui' || $comparacion === 'solo_chedraui') {
    $archivoChedraui = $dataPath . "chedraui_{$categoria}.json";
    if (file_exists($archivoChedraui)) {
        $dataChedraui = json_decode(file_get_contents($archivoChedraui), true);
        
        if (isset($dataChedraui['productos'])) {
            foreach ($dataChedraui['productos'] as $item) {
                if (isset($item['nombre']) && isset($item['precio'])) {
                    $precio = floatval($item['precio']);
                    
                    if ($precio > 0) {
                        $productosDisponibles[] = [
                            'nombre' => $item['nombre'],
                            'precio' => $precio,
                            'tienda' => 'Chedraui',
                            'imagen' => $item['imagen'] ?? ''
                        ];
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Productos</title>
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
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .content {
            padding: 40px;
        }
        
        .info-box {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        
        .info-box strong {
            color: #667eea;
        }
        
        .modo-seleccion {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            justify-content: center;
        }
        
        .modo-btn {
            flex: 1;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .modo-btn:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }
        
        .modo-btn.active {
            border-color: #667eea;
            background: #667eea;
            color: white;
        }
        
        .modo-btn input[type="radio"] {
            display: none;
        }
        
        .form-section {
            display: none;
        }
        
        .form-section.active {
            display: block;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        input[type="text"], select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        input[type="text"]:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }
        
        .producto-preview {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
            margin-top: 10px;
        }
        
        .producto-preview img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background: white;
            border-radius: 5px;
            padding: 5px;
        }
        
        .producto-preview-info {
            flex: 1;
        }
        
        .producto-preview-nombre {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .producto-preview-precio {
            color: #667eea;
            font-weight: 700;
            font-size: 18px;
        }
        
        .producto-preview-tienda {
            display: inline-block;
            padding: 3px 10px;
            background: #667eea;
            color: white;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 5px;
        }
        
        .helper-text {
            font-size: 14px;
            color: #666;
            margin-top: 8px;
        }
        
        .btn-comparar {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-comparar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        .btn-comparar:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-volver {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 24px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-volver:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .total-productos {
            text-align: center;
            padding: 10px;
            background: #e8f4f8;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #0c5460;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 Selecciona los Productos</h1>
            <p>Elige cómo quieres buscar tus productos</p>
        </div>
        
        <div class="content">
            <div class="info-box">
                <strong>📦 Categoría:</strong> <?php echo htmlspecialchars($categoria); ?><br>
                <strong>🏪 Comparación:</strong> <?php echo htmlspecialchars($comparacion); ?>
            </div>
            
            <?php if (!empty($productosDisponibles)): ?>
                <div class="total-productos">
                    📊 <?php echo count($productosDisponibles); ?> productos disponibles en esta categoría
                </div>
            <?php endif; ?>
            
            <!-- Selector de modo -->
            <div class="modo-seleccion">
                <label class="modo-btn active" id="modo-selector-btn">
                    <input type="radio" name="modo" value="selector" checked>
                    <div><strong>📋 Seleccionar de lista</strong></div>
                    <small>Más rápido y preciso</small>
                </label>
                <label class="modo-btn" id="modo-escribir-btn">
                    <input type="radio" name="modo" value="escribir">
                    <div><strong>✍️ Escribir manualmente</strong></div>
                    <small>Busca libremente</small>
                </label>
            </div>
            
            <form method="POST" action="../controlador/ComparadorPersonalizado.php?paso=3" id="form-comparacion">
                
                <!-- MODO SELECTOR -->
                <div class="form-section active" id="section-selector">
                    <div class="form-group">
                        <label for="producto1_select">🛒 Producto 1:</label>
                        <select id="producto1_select" name="producto1_select">
                            <option value="">-- Selecciona un producto --</option>
                            <?php foreach ($productosDisponibles as $index => $prod): ?>
                                <option value="<?php echo htmlspecialchars($prod['nombre']); ?>" 
                                        data-precio="<?php echo $prod['precio']; ?>"
                                        data-tienda="<?php echo $prod['tienda']; ?>"
                                        data-imagen="<?php echo htmlspecialchars($prod['imagen']); ?>">
                                    [<?php echo $prod['tienda']; ?>] <?php echo htmlspecialchars($prod['nombre']); ?> - $<?php echo number_format($prod['precio'], 2); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="preview1" class="producto-preview" style="display: none;"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="producto2_select">🛒 Producto 2:</label>
                        <select id="producto2_select" name="producto2_select">
                            <option value="">-- Selecciona un producto --</option>
                            <?php foreach ($productosDisponibles as $index => $prod): ?>
                                <option value="<?php echo htmlspecialchars($prod['nombre']); ?>"
                                        data-precio="<?php echo $prod['precio']; ?>"
                                        data-tienda="<?php echo $prod['tienda']; ?>"
                                        data-imagen="<?php echo htmlspecialchars($prod['imagen']); ?>">
                                    [<?php echo $prod['tienda']; ?>] <?php echo htmlspecialchars($prod['nombre']); ?> - $<?php echo number_format($prod['precio'], 2); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="preview2" class="producto-preview" style="display: none;"></div>
                    </div>
                </div>
                
                <!-- MODO ESCRIBIR -->
                <div class="form-section" id="section-escribir">
                    <div class="form-group">
                        <label for="producto1_text">🛒 Producto 1:</label>
                        <input type="text" id="producto1_text" name="producto1_text" placeholder="Ejemplo: Coca Cola 2 litros">
                        <div class="helper-text">Escribe el nombre del primer producto</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="producto2_text">🛒 Producto 2:</label>
                        <input type="text" id="producto2_text" name="producto2_text" placeholder="Ejemplo: Pepsi 2 litros">
                        <div class="helper-text">Escribe el nombre del segundo producto</div>
                    </div>
                </div>
                
                <!-- Hidden inputs para enviar al servidor -->
                <input type="hidden" name="producto1" id="producto1_final">
                <input type="hidden" name="producto2" id="producto2_final">
                
                <button type="submit" class="btn-comparar" id="btn-comparar">
                    ⚡ Comparar Ahora
                </button>
                
                <a href="../vista/comparador.php" class="btn-volver">← Volver al inicio</a>
            </form>
        </div>
    </div>
    
    <script>
        // Cambiar entre modos
        const modoSelectorBtn = document.getElementById('modo-selector-btn');
        const modoEscribirBtn = document.getElementById('modo-escribir-btn');
        const sectionSelector = document.getElementById('section-selector');
        const sectionEscribir = document.getElementById('section-escribir');
        
        modoSelectorBtn.addEventListener('click', () => {
            modoSelectorBtn.classList.add('active');
            modoEscribirBtn.classList.remove('active');
            sectionSelector.classList.add('active');
            sectionEscribir.classList.remove('active');
        });
        
        modoEscribirBtn.addEventListener('click', () => {
            modoEscribirBtn.classList.add('active');
            modoSelectorBtn.classList.remove('active');
            sectionEscribir.classList.add('active');
            sectionSelector.classList.remove('active');
        });
        
        // Preview de productos seleccionados
        function mostrarPreview(selectId, previewId) {
            const select = document.getElementById(selectId);
            const preview = document.getElementById(previewId);
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                const nombre = option.value;
                const precio = option.dataset.precio;
                const tienda = option.dataset.tienda;
                const imagen = option.dataset.imagen;
                
                let html = '';
                if (imagen) {
                    html += `<img src="${imagen}" alt="${nombre}" onerror="this.style.display='none'">`;
                }
                html += `
                    <div class="producto-preview-info">
                        <div class="producto-preview-nombre">${nombre}</div>
                        <div class="producto-preview-precio">$${parseFloat(precio).toFixed(2)}</div>
                        <span class="producto-preview-tienda">${tienda}</span>
                    </div>
                `;
                
                preview.innerHTML = html;
                preview.style.display = 'flex';
            } else {
                preview.style.display = 'none';
            }
        }
        
        document.getElementById('producto1_select').addEventListener('change', () => {
            mostrarPreview('producto1_select', 'preview1');
        });
        
        document.getElementById('producto2_select').addEventListener('change', () => {
            mostrarPreview('producto2_select', 'preview2');
        });
        
        // Validar y enviar formulario
        document.getElementById('form-comparacion').addEventListener('submit', (e) => {
            e.preventDefault();
            
            let producto1, producto2;
            
            // Determinar qué modo está activo
            if (sectionSelector.classList.contains('active')) {
                // Modo selector
                producto1 = document.getElementById('producto1_select').value;
                producto2 = document.getElementById('producto2_select').value;
                
                if (!producto1 || !producto2) {
                    alert('Por favor selecciona ambos productos');
                    return;
                }
            } else {
                // Modo escribir
                producto1 = document.getElementById('producto1_text').value.trim();
                producto2 = document.getElementById('producto2_text').value.trim();
                
                if (!producto1 || !producto2) {
                    alert('Por favor escribe ambos productos');
                    return;
                }
            }
            
            // Asignar a hidden inputs
            document.getElementById('producto1_final').value = producto1;
            document.getElementById('producto2_final').value = producto2;
            
            // Enviar formulario
            e.target.submit();
        });
    </script>
</body>
</html>