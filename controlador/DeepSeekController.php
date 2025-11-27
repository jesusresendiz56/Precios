<?php
// Recuperar datos de la sesión
$resultado = $_SESSION['resultado_comparacion'] ?? null;
$categoria = $_SESSION['categoria'] ?? 'Productos';
$periodo = $_SESSION['periodo'] ?? '';

if (!$resultado) {
    die("Error: No hay resultados para mostrar");
}

$productos = $resultado['productos'] ?? [];
$resumen = $resultado['resumen'] ?? [];
$recomendacion = $resultado['recomendacion'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Comparación</title>
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
        }
        
        .header {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 18px;
        }
        
        .ganador-card {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .ganador-card h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .ganador-card .tienda {
            font-size: 48px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
        }
        
        .ahorro-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .recomendacion-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .recomendacion-card h3 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .recomendacion-card p {
            color: #444;
            font-size: 16px;
            line-height: 1.8;
        }
        
        .productos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .producto-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .producto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .producto-nombre {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        
        .precio-comparacion {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .tienda-precio {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
        }
        
        .tienda-precio.walmart {
            background: #e3f2fd;
            margin-right: 10px;
        }
        
        .tienda-precio.chedraui {
            background: #fff3e0;
        }
        
        .tienda-precio .label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
        }
        
        .tienda-precio .precio {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 5px 0;
        }
        
        .tienda-precio .presentacion {
            font-size: 11px;
            color: #888;
        }
        
        .ganador-badge {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }
        
        .ahorro-info {
            background: #f0f9ff;
            padding: 10px;
            border-radius: 10px;
            margin-top: 10px;
            text-align: center;
        }
        
        .ahorro-info .cantidad {
            font-size: 18px;
            font-weight: bold;
            color: #11998e;
        }
        
        .btn-nueva {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 30px auto;
            padding: 15px;
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .btn-nueva:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .resumen-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .stat-box {
            background: rgba(255,255,255,0.2);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
        
        .stat-box .label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        
        .stat-box .value {
            font-size: 28px;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .productos-grid {
                grid-template-columns: 1fr;
            }
            
            .ganador-card .tienda {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📊 Resultados de Comparación</h1>
            <p><?php echo htmlspecialchars($categoria); ?> - Compra para <?php echo htmlspecialchars($periodo); ?></p>
        </div>
        
        <!-- Tarjeta de Ganador -->
        <?php if (!empty($resumen['tienda_ganadora'])): ?>
        <div class="ganador-card">
            <h2>🏆 ¡La mejor opción es!</h2>
            <div class="tienda"><?php echo htmlspecialchars($resumen['tienda_ganadora']); ?></div>
            
            <div class="resumen-stats">
                <div class="stat-box">
                    <div class="label">Total en Walmart</div>
                    <div class="value">$<?php echo number_format($resumen['total_walmart'] ?? 0, 2); ?></div>
                </div>
                <div class="stat-box">
                    <div class="label">Total en Chedraui</div>
                    <div class="value">$<?php echo number_format($resumen['total_chedraui'] ?? 0, 2); ?></div>
                </div>
                <div class="stat-box">
                    <div class="label">Ahorras</div>
                    <div class="value">$<?php echo number_format($resumen['ahorro_total'] ?? 0, 2); ?></div>
                </div>
            </div>
            
            <?php if (!empty($resumen['ahorro_porcentaje_total'])): ?>
            <div class="ahorro-badge">
                💰 Ahorro del <?php echo number_format($resumen['ahorro_porcentaje_total'], 1); ?>%
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <!-- Recomendación de la IA -->
        <?php if (!empty($recomendacion)): ?>
        <div class="recomendacion-card">
            <h3>💡 Recomendación Personalizada</h3>
            <p><?php echo nl2br(htmlspecialchars($recomendacion)); ?></p>
        </div>
        <?php endif; ?>
        
        <!-- Grid de Productos -->
        <div class="productos-grid">
            <?php foreach ($productos as $producto): ?>
            <div class="producto-card">
                <div class="producto-nombre">
                    <?php echo htmlspecialchars($producto['nombre']); ?>
                </div>
                
                <div class="precio-comparacion">
                    <div class="tienda-precio walmart">
                        <div class="label">Walmart</div>
                        <div class="precio">$<?php echo number_format($producto['walmart_precio'], 2); ?></div>
                        <div class="presentacion">
                            <?php echo htmlspecialchars($producto['walmart_presentacion'] ?? ''); ?>
                        </div>
                    </div>
                    
                    <div class="tienda-precio chedraui">
                        <div class="label">Chedraui</div>
                        <div class="precio">$<?php echo number_format($producto['chedraui_precio'], 2); ?></div>
                        <div class="presentacion">
                            <?php echo htmlspecialchars($producto['chedraui_presentacion'] ?? ''); ?>
                        </div>
                    </div>
                </div>
                
                <div class="ganador-badge">
                    ✓ Mejor precio: <?php echo htmlspecialchars($producto['mas_barato']); ?>
                </div>
                
                <?php if (!empty($producto['ahorro'])): ?>
                <div class="ahorro-info">
                    <div class="cantidad">
                        Ahorras $<?php echo number_format($producto['ahorro'], 2); ?>
                        <?php if (!empty($producto['ahorro_porcentaje'])): ?>
                            (<?php echo number_format($producto['ahorro_porcentaje'], 1); ?>%)
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Botón para nueva comparación -->
        <a href="../vista/comparador.php" class="btn-nueva">
            🔄 Hacer otra comparación
        </a>
    </div>
</body>
</html>