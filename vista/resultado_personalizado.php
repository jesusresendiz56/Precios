<?php
// NO iniciar sesión aquí porque ya está iniciada en ComparadorPersonalizado.php

// Validar que existan los resultados
if (!isset($_SESSION['recomendacion_ia'])) {
    header('Location: ../vista/comparador.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Comparación</title>
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
            max-width: 1200px;
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
        
        .content {
            padding: 40px;
        }
        
        .productos-comparados {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .producto-card {
            background: #f9f9f9;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 3px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .producto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .producto-card.walmart {
            border-color: #0071ce;
        }
        
        .producto-card.chedraui {
            border-color: #e31e24;
        }
        
        .producto-imagen {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background: white;
            border-radius: 10px;
            margin-bottom: 15px;
            padding: 10px;
        }
        
        .producto-imagen-placeholder {
            width: 100%;
            height: 200px;
            background: #e0e0e0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .tienda-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
            color: white;
        }
        
        .tienda-badge.walmart {
            background: #0071ce;
        }
        
        .tienda-badge.chedraui {
            background: #e31e24;
        }
        
        .producto-nombre {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            line-height: 1.4;
            min-height: 44px;
        }
        
        .producto-precio {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
            margin: 15px 0;
        }
        
        .producto-presentacion {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .producto-descripcion {
            font-size: 13px;
            color: #888;
            line-height: 1.4;
        }
        
        .no-encontrado {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #856404;
        }
        
        .resultado-box {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #667eea;
        }
        
        .resultado-box h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .recomendacion-ia {
            background: white;
            padding: 25px;
            border-radius: 10px;
            font-size: 15px;
            line-height: 1.8;
            color: #333;
            white-space: pre-wrap;
            word-wrap: break-word;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .btn-volver {
            display: inline-block;
            padding: 15px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-volver:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .busqueda-info {
            background: #e8f4f8;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #17a2b8;
        }
        
        .busqueda-info strong {
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Resultado de Comparación</h1>
            <p>Análisis completo de tus productos</p>
        </div>
        
        <div class="content">
            <div class="busqueda-info">
                <strong>🔍 Buscaste:</strong><br>
                • <?php echo htmlspecialchars($_SESSION['producto1_buscado'] ?? 'N/A'); ?><br>
                • <?php echo htmlspecialchars($_SESSION['producto2_buscado'] ?? 'N/A'); ?>
            </div>
            
            <h2 style="margin-bottom: 20px; color: #333;">🛒 Productos Encontrados</h2>
            
            <div class="productos-comparados">
                <!-- Producto 1 -->
                <?php if (isset($_SESSION['producto1_encontrado']) && $_SESSION['producto1_encontrado']): ?>
                    <?php $prod1 = $_SESSION['producto1_encontrado']; ?>
                    <div class="producto-card <?php echo strtolower($prod1['tienda']); ?>">
                        <span class="tienda-badge <?php echo strtolower($prod1['tienda']); ?>">
                            <?php echo htmlspecialchars($prod1['tienda']); ?>
                        </span>
                        
                        <?php if (!empty($prod1['imagen'])): ?>
                            <img src="<?php echo htmlspecialchars($prod1['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($prod1['nombre']); ?>" 
                                 class="producto-imagen"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="producto-imagen-placeholder" style="display: none;">
                                📦 Sin imagen
                            </div>
                        <?php else: ?>
                            <div class="producto-imagen-placeholder">
                                📦 Sin imagen
                            </div>
                        <?php endif; ?>
                        
                        <div class="producto-nombre">
                            <?php echo htmlspecialchars($prod1['nombre']); ?>
                        </div>
                        
                        <div class="producto-precio">
                            $<?php echo number_format($prod1['precio'], 2); ?>
                        </div>
                        
                        <div class="producto-presentacion">
                            📦 <?php echo htmlspecialchars($prod1['presentacion']); ?>
                        </div>
                        
                        <?php if (!empty($prod1['descripcion'])): ?>
                            <div class="producto-descripcion">
                                <?php echo htmlspecialchars($prod1['descripcion']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="no-encontrado">
                        <strong>⚠️ Producto 1 no encontrado</strong><br>
                        No se encontró "<?php echo htmlspecialchars($_SESSION['producto1_buscado']); ?>" en los datos disponibles.
                    </div>
                <?php endif; ?>
                
                <!-- Producto 2 -->
                <?php if (isset($_SESSION['producto2_encontrado']) && $_SESSION['producto2_encontrado']): ?>
                    <?php $prod2 = $_SESSION['producto2_encontrado']; ?>
                    <div class="producto-card <?php echo strtolower($prod2['tienda']); ?>">
                        <span class="tienda-badge <?php echo strtolower($prod2['tienda']); ?>">
                            <?php echo htmlspecialchars($prod2['tienda']); ?>
                        </span>
                        
                        <?php if (!empty($prod2['imagen'])): ?>
                            <img src="<?php echo htmlspecialchars($prod2['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($prod2['nombre']); ?>" 
                                 class="producto-imagen"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="producto-imagen-placeholder" style="display: none;">
                                📦 Sin imagen
                            </div>
                        <?php else: ?>
                            <div class="producto-imagen-placeholder">
                                📦 Sin imagen
                            </div>
                        <?php endif; ?>
                        
                        <div class="producto-nombre">
                            <?php echo htmlspecialchars($prod2['nombre']); ?>
                        </div>
                        
                        <div class="producto-precio">
                            $<?php echo number_format($prod2['precio'], 2); ?>
                        </div>
                        
                        <div class="producto-presentacion">
                            📦 <?php echo htmlspecialchars($prod2['presentacion']); ?>
                        </div>
                        
                        <?php if (!empty($prod2['descripcion'])): ?>
                            <div class="producto-descripcion">
                                <?php echo htmlspecialchars($prod2['descripcion']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="no-encontrado">
                        <strong>⚠️ Producto 2 no encontrado</strong><br>
                        No se encontró "<?php echo htmlspecialchars($_SESSION['producto2_buscado']); ?>" en los datos disponibles.
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="resultado-box">
                <h2>🤖 Análisis de IA</h2>
                <div class="recomendacion-ia"><?php echo nl2br(htmlspecialchars($_SESSION['recomendacion_ia'])); ?></div>
            </div>
            
            <a href="../vista/comparador.php" class="btn-volver">← Nueva Comparación</a>
        </div>
    </div>
</body>
</html>