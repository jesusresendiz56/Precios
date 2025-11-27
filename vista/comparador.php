<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador Personalizado</title>
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
            max-width: 700px;
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
        
        .header p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        .content {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 30px;
        }
        
        label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        select, input[type="text"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            background: white;
            transition: all 0.3s;
        }
        
        select:hover, input[type="text"]:hover {
            border-color: #667eea;
        }
        
        select:focus, input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .tiendas-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .tienda-option {
            flex: 1;
            min-width: 200px;
        }
        
        .tienda-option input[type="radio"] {
            display: none;
        }
        
        .tienda-option label {
            display: block;
            padding: 20px;
            border: 3px solid #e0e0e0;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 18px;
        }
        
        .tienda-option input[type="radio"]:checked + label {
            border-color: #667eea;
            background: #667eea;
            color: white;
            transform: scale(1.05);
        }
        
        .tienda-option label:hover {
            border-color: #667eea;
        }
        
        .btn-siguiente {
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
        
        .btn-siguiente:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        .btn-siguiente:active {
            transform: translateY(0);
        }
        
        .helper-text {
            font-size: 14px;
            color: #666;
            margin-top: 8px;
        }
        
        @media (max-width: 600px) {
            .tiendas-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Comparador Inteligente</h1>
            <p>Compara productos y obtén la mejor recomendación</p>
        </div>
        
        <div class="content">
            <form method="POST" action="../controlador/ComparadorPersonalizado.php?paso=2">
                <div class="form-group">
                    <label for="categoria">🏷️ Paso 1: ¿Qué categoría quieres comparar?</label>
                    <select name="categoria" id="categoria" required>
                        <option value="">-- Selecciona una categoría --</option>
                        <option value="arroz">🍚 Arroz</option>
                        <option value="papel">🧻 Papel</option>
                        <option value="refrescos">🥤 Refrescos</option>
                        <option value="galletas">🍪 Galletas</option>
                        <option value="lacteos">🥛 Lácteos</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>🏬 Paso 2: ¿Entre qué tiendas quieres comparar?</label>
                    <div class="tiendas-group">
                        <div class="tienda-option">
                            <input type="radio" name="comparacion" id="walmart_chedraui" value="walmart_chedraui" required>
                            <label for="walmart_chedraui">
                                Walmart<br>vs<br>Chedraui
                            </label>
                        </div>
                        <div class="tienda-option">
                            <input type="radio" name="comparacion" id="solo_walmart" value="solo_walmart">
                            <label for="solo_walmart">
                                Solo<br>Walmart
                            </label>
                        </div>
                        <div class="tienda-option">
                            <input type="radio" name="comparacion" id="solo_chedraui" value="solo_chedraui">
                            <label for="solo_chedraui">
                                Solo<br>Chedraui
                            </label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn-siguiente">
                    Siguiente: Ingresar Productos 🔍
                </button>
            </form>
        </div>
    </div>
</body>
</html>