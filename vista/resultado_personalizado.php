<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Comparación - ItemWise</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2992ef;
            --secondary: #764ba2;
            --dark: #333;
            --light: #f8f9fa;
            --border-radius: 15px;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 100px auto 50px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 16px;
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
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 3px solid #e0e0e0;
            transition: all 0.3s;
            position: relative;
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
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
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
            color: var(--dark);
            margin-bottom: 15px;
            line-height: 1.4;
            min-height: 44px;
        }
        
        .producto-precio {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            margin: 20px 0;
        }
        
        .producto-presentacion {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
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
            padding: 25px;
            text-align: center;
            color: #856404;
            font-weight: 600;
        }
        
        .resultado-box {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            border-left: 5px solid var(--primary);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .resultado-box h2 {
            color: var(--dark);
            margin-bottom: 20px;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .recomendacion-ia {
            background: var(--light);
            padding: 25px;
            border-radius: 10px;
            font-size: 15px;
            line-height: 1.8;
            color: var(--dark);
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .btn-volver {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-volver:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .busqueda-info {
            background: #e8f4f8;
            padding: 20px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            border-left: 4px solid var(--primary);
            font-size: 15px;
        }
        
        .busqueda-info strong {
            color: var(--primary);
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .container {
                margin: 80px auto 30px;
            }

            .content {
                padding: 25px;
            }

            .productos-comparados {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .producto-card {
                padding: 20px;
            }

            .header {
                padding: 25px 20px;
            }

            .header h1 {
                font-size: 24px;
            }
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
            
            <h2 style="margin-bottom: 20px; color: var(--dark);">🛒 Productos Encontrados</h2>
            
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
            
            <a href="../vista/comparador.php" class="btn-volver">
                <i class="fas fa-arrow-left"></i>
                Nueva Comparación
            </a>
        </div>
    </div>
</body>
</html>