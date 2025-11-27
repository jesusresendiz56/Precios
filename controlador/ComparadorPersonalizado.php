<?php
// Este archivo va en: controlador/ComparadorPersonalizado.php

class ComparadorPersonalizado {
    
    private $apiKey;
    private $dataPath;
    
    public function __construct() {
        // API Key de DeepSeek
        $this->apiKey = 'sk-db23a8d2d39f4fcb83e1af6e0b165878';
        
        // CORREGIDO: Ruta a los archivos de datos
        // Desde: C:\xampp\htdocs\precios\precios\controlador\
        // Hasta: C:\xampp\htdocs\precios\precios\scr\tiendas\data\
        $this->dataPath = __DIR__ . '/../scr/tiendas/data/';
        
        // Iniciar sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Normaliza los datos de Walmart
     */
    private function normalizarWalmart($data) {
        $productos = [];
        
        // Manejar estructura con search_results
        if (isset($data['search_results'])) {
            foreach ($data['search_results'] as $resultado) {
                if (isset($resultado['item'])) {
                    foreach ($resultado['item'] as $item) {
                        $producto = $this->procesarItemWalmart($item);
                        if ($producto) {
                            $productos[] = $producto;
                        }
                    }
                }
            }
        } 
        // Manejar array directo de items
        else if (is_array($data)) {
            foreach ($data as $item) {
                $producto = $this->procesarItemWalmart($item);
                if ($producto) {
                    $productos[] = $producto;
                }
            }
        }
        
        return $productos;
    }
    
    /**
     * Procesa un item individual de Walmart
     */
    private function procesarItemWalmart($item) {
        if (!isset($item['title']) || !isset($item['current_price'])) {
            return null;
        }
        
        // Limpiar precio
        $precio = is_string($item['current_price']) 
            ? floatval(preg_replace('/[^0-9.]/', '', $item['current_price']))
            : floatval($item['current_price']);
        
        // Ignorar productos sin precio válido
        if ($precio <= 0) {
            return null;
        }
        
        return [
            'tienda' => 'Walmart',
            'nombre' => $item['title'],
            'precio' => $precio,
            'presentacion' => $item['brand'] ?? 'Sin marca',
            'descripcion' => ($item['availability_status'] ?? '') . ' ' . ($item['brand'] ?? ''),
            'imagen' => $item['thumbnail'] ?? '',
            'url' => $item['product_page_url'] ?? ''
        ];
    }
    
    /**
     * Normaliza los datos de Chedraui
     */
    private function normalizarChedraui($data) {
        $productos = [];
        
        if (!isset($data['productos'])) {
            return $productos;
        }
        
        foreach ($data['productos'] as $item) {
            // Validar datos requeridos
            if (!isset($item['nombre']) || !isset($item['precio'])) {
                continue;
            }
            
            $precio = floatval($item['precio']);
            
            // Ignorar productos sin precio válido
            if ($precio <= 0) {
                continue;
            }
            
            $descripcion = ($item['presentacion'] ?? '');
            if (isset($item['promocion']) && !empty($item['promocion'])) {
                $descripcion .= ' - ' . $item['promocion'];
            }
            
            $productos[] = [
                'tienda' => 'Chedraui',
                'nombre' => $item['nombre'],
                'precio' => $precio,
                'presentacion' => $item['presentacion'] ?? 'Sin presentación',
                'descripcion' => $descripcion,
                'imagen' => $item['imagen'] ?? '',
                'url' => $item['url'] ?? ''
            ];
        }
        
        return $productos;
    }
    
    /**
     * Carga productos desde archivos JSON
     */
    private function cargarProductos($categoria, $comparacion) {
        $resultado = [
            'walmart' => [],
            'chedraui' => []
        ];
        
        // DEBUG: Mostrar información de depuración
        $debugInfo = [];
        $debugInfo['dataPath'] = $this->dataPath;
        $debugInfo['categoria'] = $categoria;
        $debugInfo['comparacion'] = $comparacion;
        
        // Cargar Walmart
        if ($comparacion === 'walmart_chedraui' || $comparacion === 'solo_walmart') {
            $archivoWalmart = $this->dataPath . "walmart_{$categoria}.json";
            $debugInfo['archivoWalmart'] = $archivoWalmart;
            $debugInfo['walmartExists'] = file_exists($archivoWalmart);
            
            if (file_exists($archivoWalmart)) {
                $dataWalmart = json_decode(file_get_contents($archivoWalmart), true);
                $resultado['walmart'] = $this->normalizarWalmart($dataWalmart);
                $debugInfo['walmartProductos'] = count($resultado['walmart']);
            }
        }
        
        // Cargar Chedraui
        if ($comparacion === 'walmart_chedraui' || $comparacion === 'solo_chedraui') {
            $archivoChedraui = $this->dataPath . "chedraui_{$categoria}.json";
            $debugInfo['archivoChedraui'] = $archivoChedraui;
            $debugInfo['chedrauiExists'] = file_exists($archivoChedraui);
            
            if (file_exists($archivoChedraui)) {
                $dataChedraui = json_decode(file_get_contents($archivoChedraui), true);
                $resultado['chedraui'] = $this->normalizarChedraui($dataChedraui);
                $debugInfo['chedrauiProductos'] = count($resultado['chedraui']);
            }
        }
        
        // Guardar debug en sesión
        $_SESSION['debug_info'] = $debugInfo;
        
        return $resultado;
    }
    
    /**
     * Busca el producto más similar en un array de productos
     */
    private function buscarProductoSimilar($nombreBuscado, $productos) {
        if (empty($productos)) {
            return null;
        }
        
        $nombreBuscado = strtolower($nombreBuscado);
        $mejorMatch = null;
        $mejorScore = 0;
        
        // Palabras clave para ignorar en la búsqueda
        $stopWords = ['de', 'la', 'el', 'un', 'una', 'los', 'las', 'del', 'con'];
        
        foreach ($productos as $producto) {
            $nombreProducto = strtolower($producto['nombre']);
            $score = 0;
            
            // Dividir en palabras y filtrar stopwords
            $palabrasBuscadas = array_filter(
                explode(' ', $nombreBuscado),
                function($palabra) use ($stopWords) {
                    return strlen($palabra) > 2 && !in_array($palabra, $stopWords);
                }
            );
            
            // Buscar coincidencias de palabras
            foreach ($palabrasBuscadas as $palabra) {
                // Coincidencia exacta vale más
                if (strpos($nombreProducto, $palabra) !== false) {
                    $score += 3;
                }
                // Coincidencia parcial (similar_text)
                similar_text($palabra, $nombreProducto, $percent);
                if ($percent > 50) {
                    $score += 1;
                }
            }
            
            // Bonus si el nombre del producto contiene TODAS las palabras importantes
            $todasLasPalabras = true;
            foreach ($palabrasBuscadas as $palabra) {
                if (strpos($nombreProducto, $palabra) === false) {
                    $todasLasPalabras = false;
                    break;
                }
            }
            if ($todasLasPalabras && count($palabrasBuscadas) > 0) {
                $score += 5;
            }
            
            // Actualizar mejor match
            if ($score > $mejorScore) {
                $mejorScore = $score;
                $mejorMatch = $producto;
            }
        }
        
        // Solo devolver si hay un score mínimo razonable
        return ($mejorScore >= 3) ? $mejorMatch : null;
    }
    
    /**
     * Busca y compara productos usando IA
     */
    private function buscarYComparar($producto1, $producto2, $productos) {
        // Buscar productos similares
        $todosProductos = array_merge($productos['walmart'], $productos['chedraui']);
        
        $productoEncontrado1 = $this->buscarProductoSimilar($producto1, $todosProductos);
        $productoEncontrado2 = $this->buscarProductoSimilar($producto2, $todosProductos);
        
        // Construir prompt para la IA
        $prompt = $this->construirPrompt($producto1, $producto2, $productos, $productoEncontrado1, $productoEncontrado2);
        
        // Llamada a la API de IA
        try {
            $resultado = $this->llamarIA($prompt);
            
            return [
                'success' => true,
                'recomendacion' => $resultado,
                'producto1_encontrado' => $productoEncontrado1,
                'producto2_encontrado' => $productoEncontrado2
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'recomendacion' => 'Error al obtener recomendación: ' . $e->getMessage(),
                'producto1_encontrado' => $productoEncontrado1,
                'producto2_encontrado' => $productoEncontrado2
            ];
        }
    }
    
    /**
     * Realiza la llamada a la API de IA (DeepSeek)
     */
    private function llamarIA($prompt) {
        $apiUrl = 'https://api.deepseek.com/v1/chat/completions';
        
        $data = [
            'model' => 'deepseek-chat',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Eres un experto en comparación de precios de supermercado en México. Das recomendaciones claras y específicas considerando precio y calidad.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'max_tokens' => 4000,
            'temperature' => 0.7,
            'stream' => false
        ];
        
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        if ($httpCode !== 200) {
            throw new Exception("Error en la API DeepSeek: HTTP $httpCode - $curlError - Response: " . substr($response, 0, 500));
        }
        
        $resultado = json_decode($response, true);
        
        // Extraer el texto de la respuesta (formato OpenAI/DeepSeek)
        if (isset($resultado['choices'][0]['message']['content'])) {
            return $resultado['choices'][0]['message']['content'];
        }
        
        throw new Exception("Formato de respuesta inválido de DeepSeek: " . json_encode($resultado));
    }
    
    /**
     * Construye el prompt para la IA con análisis de precio por unidad y calidad
     */
    private function construirPrompt($producto1, $producto2, $productos, $prod1Encontrado, $prod2Encontrado) {
        $prompt = "Eres un experto en comparación de precios de supermercado en México. Tu trabajo es ayudar al cliente a decidir QUÉ PRODUCTO COMPRAR y DÓNDE COMPRARLO considerando PRECIO Y CALIDAD.\n\n";
        
        $prompt .= "EL USUARIO QUIERE COMPARAR:\n";
        $prompt .= "➡️ {$producto1} (Producto A)\n";
        $prompt .= "➡️ {$producto2} (Producto B)\n\n";
        
        $prompt .= "🔍 PRODUCTOS QUE ENCONTRAMOS:\n\n";
        
        if ($prod1Encontrado) {
            $prompt .= "PRODUCTO A - {$producto1}:\n";
            $prompt .= "  • Nombre: {$prod1Encontrado['nombre']}\n";
            $prompt .= "  • Precio: \${$prod1Encontrado['precio']} MXN\n";
            $prompt .= "  • Tienda: {$prod1Encontrado['tienda']}\n";
            $prompt .= "  • Presentación: {$prod1Encontrado['presentacion']}\n\n";
        } else {
            $prompt .= "PRODUCTO A: ❌ No encontrado en los datos\n\n";
        }
        
        if ($prod2Encontrado) {
            $prompt .= "PRODUCTO B - {$producto2}:\n";
            $prompt .= "  • Nombre: {$prod2Encontrado['nombre']}\n";
            $prompt .= "  • Precio: \${$prod2Encontrado['precio']} MXN\n";
            $prompt .= "  • Tienda: {$prod2Encontrado['tienda']}\n";
            $prompt .= "  • Presentación: {$prod2Encontrado['presentacion']}\n\n";
        } else {
            $prompt .= "PRODUCTO B: ❌ No encontrado en los datos\n\n";
        }
        
        $prompt .= "📋 OTROS PRODUCTOS SIMILARES DISPONIBLES:\n";
        $prompt .= json_encode($productos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
        
        $prompt .= "🎯 TU MISIÓN:\n";
        $prompt .= "Dar una recomendación CLARA y ESPECÍFICA siguiendo este formato EXACTO:\n\n";
        
        
        $prompt .= " COMPARACIÓN DIRECTA\n";
        $prompt .= "Producto A ({$producto1}):";
        $prompt .= "- Precio total: \$XX.XX\n";
        $prompt .= "- Precio por [unidad]: \$XX.XX\n";
        $prompt .= "- Tienda: [Nombre]\n\n";
        
        $prompt .= "Producto B ({$producto2}):\n";
        $prompt .= "- Precio total: \$XX.XX\n";
        $prompt .= "- Precio por [unidad]: \$XX.XX\n";
        $prompt .= "- Tienda: [Nombre]\n\n";
        
        $prompt .= "💡 ANÁLISIS DE RENDIMIENTO\n";
        $prompt .= "- Calcula el precio por unidad (litro, kilo, rollo, pieza, etc.)\n";
        $prompt .= "- Compara presentaciones diferentes\n";
        $prompt .= "- Si las cantidades son diferentes, calcula cuántas unidades del más barato necesitas para igualar al otro\n";
        $prompt .= "- Ejemplo: 'Para igualar 18 rollos, necesitas 5 paquetes de 4 = 20 rollos por \$137.50'\n\n";
        
        $prompt .= "🏅 ANÁLISIS DE CALIDAD Y MARCAS\n";
        $prompt .= "Evalúa la calidad de las marcas y productos:\n";
        $prompt .= "- Marcas PREMIUM (alta calidad): Kleenex, Charmin, Bounty, Ariel, Tide, Coca-Cola, Pepsi, Lala, Alpura, Bimbo\n";
        $prompt .= "- Marcas CONFIABLES (calidad media-alta): Suavel, Pétalo, Regio, Roma, Great Value, Member's Mark\n";
        $prompt .= "- Marcas ECONÓMICAS (funcional): Genéricas, marcas blancas\n\n";
        $prompt .= "Considera:\n";
        $prompt .= "• Durabilidad/Rendimiento (ej: papel de 2 hojas vs 1 hoja)\n";
        $prompt .= "• Reputación de marca (ej: Kleenex vs genérico)\n";
        $prompt .= "• Características especiales (ej: ultrapasteurizada, hipoalergénico)\n";
        $prompt .= "• Experiencia común del usuario mexicano\n\n";
        $prompt .= "Formato sugerido:\n";
        $prompt .= "'Producto A: [Marca Premium/Confiable/Económica] - [Características]'\n";
        $prompt .= "'Producto B: [Marca Premium/Confiable/Económica] - [Características]'\n";
        $prompt .= "'Diferencia de calidad: [Explicación breve]'\n\n";
        
        $prompt .= "🔢 CÁLCULO DE CANTIDAD EQUIVALENTE (MUY IMPORTANTE)\n";
        $prompt .= "Si los productos tienen diferentes cantidades:\n";
        $prompt .= "1. Calcula cuántos paquetes del más barato necesitas para igualar o superar la cantidad del otro\n";
        $prompt .= "2. Multiplica: [cantidad de paquetes] × [precio unitario] = [costo total]\n";
        $prompt .= "3. Compara este costo total vs el producto de mayor cantidad\n";
        $prompt .= "Ejemplo formato:\n";
        $prompt .= "  'Producto A: 18 unidades por \$199'\n";
        $prompt .= "  'Producto B: Para 18 unidades necesitas 5 paquetes (4×5=20) = \$137.50'\n";
        $prompt .= "  'Diferencia: Ahorras \$61.50'\n\n";
        
        $prompt .= "🏆 RECOMENDACIÓN FINAL\n";
        $prompt .= "TE RECOMIENDO COMPRAR: [Nombre exacto del producto]\n";
        $prompt .= "EN: [Walmart/Chedraui]\n";
        $prompt .= "CANTIDAD SUGERIDA: [X paquetes/unidades]\n";
        $prompt .= "COSTO TOTAL: \$XX.XX\n";
        $prompt .= "PORQUE: [Explicación considerando PRECIO + CALIDAD]\n\n";
        $prompt .= "ALTERNATIVA (si aplica):\n";
        $prompt .= "Si prefieres [ahorro máximo/mejor calidad]: [Producto alternativo]\n\n";
        
        $prompt .= "💰 AHORRO TOTAL\n";
        $prompt .= "Comprando [X paquetes de producto recomendado]:\n";
        $prompt .= "- Obtienes: [X] unidades por \$XX.XX\n";
        $prompt .= "- vs comprar el otro: [X] unidades por \$XX.XX\n";
        $prompt .= "- AHORRO: \$XX.XX pesos (XX%)\n\n";
        
        $prompt .= "📝 NOTAS ADICIONALES\n";
        $prompt .= "- Menciona si sobran unidades y cuántas\n";
        $prompt .= "- Considera la relación precio-calidad final\n";
        $prompt .= "- Sugiere para qué tipo de usuario es mejor cada opción\n";
        $prompt .= "- Ejemplo: 'Ideal para familias grandes' o 'Mejor si buscas máximo ahorro'\n\n";
        
        $prompt .= "---FIN DE RESPUESTA---\n\n";
        
        $prompt .= "⚠️ REGLAS IMPORTANTES:\n";
        $prompt .= "1. SIEMPRE analiza la calidad de las marcas (Premium/Confiable/Económica)\n";
        $prompt .= "2. SIEMPRE calcula el costo equivalente cuando las cantidades son diferentes\n";
        $prompt .= "3. Balancea PRECIO y CALIDAD en tu recomendación\n";
        $prompt .= "4. Si hay gran diferencia de calidad, menciónalo aunque uno sea más barato\n";
        $prompt .= "5. Muestra TODOS los cálculos matemáticos paso a paso\n";
        $prompt .= "6. Di EXACTAMENTE cuántos paquetes comprar del recomendado\n";
        $prompt .= "7. Calcula el AHORRO TOTAL en pesos, no solo por unidad\n";
        $prompt .= "8. Sé SUPER ESPECÍFICO: 'Compra 5 paquetes de [producto] en [tienda] = \$XX.XX total'\n";
        $prompt .= "9. Da opciones si hay trade-off entre precio y calidad\n";
        $prompt .= "10. Usa contexto mexicano: marcas conocidas en México\n\n";
        
        $prompt .= "EJEMPLO DE RESPUESTA COMPLETA:\n";
        $prompt .= "Si comparas Kleenex (premium, \$7/rollo) vs Genérico (\$3/rollo):\n";
        $prompt .= "'🏆 RECOMENDACIÓN: Kleenex en Chedraui\n";
        $prompt .= "PORQUE: Aunque es el doble de precio, Kleenex es marca premium con mejor suavidad y resistencia.\n";
        $prompt .= "El ahorro del genérico (\$4/rollo) no justifica la diferencia de calidad.\n\n";
        $prompt .= "ALTERNATIVA: Si tu presupuesto es muy ajustado, el genérico cumple su función básica.'\n\n";
        
        $prompt .= "Responde ahora siguiendo el formato exacto. El usuario necesita una respuesta clara que considere PRECIO Y CALIDAD.";
        
        return $prompt;
    }
    
    /**
     * Muestra el formulario de selección
     */
    public function mostrarFormulario() {
        if (!isset($_POST['categoria']) || !isset($_POST['comparacion'])) {
            throw new Exception('Debes seleccionar categoría y tipo de comparación');
        }
        
        $_SESSION['categoria'] = $_POST['categoria'];
        $_SESSION['comparacion'] = $_POST['comparacion'];
        
        require_once __DIR__ . '/../vista/seleccionar_productos.php';
    }
    
    /**
     * Compara productos seleccionados
     */
    public function compararProductos() {
        if (!isset($_POST['producto1']) || !isset($_POST['producto2'])) {
            throw new Exception('Debes escribir ambos productos');
        }
        
        $producto1 = $_POST['producto1'];
        $producto2 = $_POST['producto2'];
        $categoria = $_SESSION['categoria'];
        $comparacion = $_SESSION['comparacion'];
        
        // Cargar productos
        $productos = $this->cargarProductos($categoria, $comparacion);
        
        // Verificar que se cargaron productos
        $totalProductos = count($productos['walmart']) + count($productos['chedraui']);
        if ($totalProductos === 0) {
            $error = "No se encontraron productos en la categoría seleccionada.\n\n";
            $error .= "🔍 INFORMACIÓN DE DEPURACIÓN:\n";
            $error .= "Ruta base: " . $this->dataPath . "\n";
            $error .= "Categoría: " . $categoria . "\n";
            $error .= "Comparación: " . $comparacion . "\n\n";
            
            if (isset($_SESSION['debug_info'])) {
                $debug = $_SESSION['debug_info'];
                
                if (isset($debug['archivoWalmart'])) {
                    $error .= "Archivo Walmart: " . $debug['archivoWalmart'] . "\n";
                    $error .= "¿Existe?: " . ($debug['walmartExists'] ? 'SÍ' : 'NO') . "\n";
                    if ($debug['walmartExists']) {
                        $error .= "Productos cargados: " . ($debug['walmartProductos'] ?? 0) . "\n";
                    }
                    $error .= "\n";
                }
                
                if (isset($debug['archivoChedraui'])) {
                    $error .= "Archivo Chedraui: " . $debug['archivoChedraui'] . "\n";
                    $error .= "¿Existe?: " . ($debug['chedrauiExists'] ? 'SÍ' : 'NO') . "\n";
                    if ($debug['chedrauiExists']) {
                        $error .= "Productos cargados: " . ($debug['chedrauiProductos'] ?? 0) . "\n";
                    }
                }
            }
            
            // Listar archivos que SÍ existen en el directorio
            $error .= "\n📁 Archivos disponibles en el directorio:\n";
            if (is_dir($this->dataPath)) {
                $archivos = scandir($this->dataPath);
                foreach ($archivos as $archivo) {
                    if ($archivo != '.' && $archivo != '..') {
                        $error .= "  - " . $archivo . "\n";
                    }
                }
            } else {
                $error .= "  ⚠️ El directorio no existe!\n";
            }
            
            throw new Exception($error);
        }
        
        // Buscar y comparar
        $resultado = $this->buscarYComparar($producto1, $producto2, $productos);
        
        // Guardar en sesión
        $_SESSION['producto1_buscado'] = $producto1;
        $_SESSION['producto2_buscado'] = $producto2;
        $_SESSION['recomendacion_ia'] = $resultado['recomendacion'];
        $_SESSION['producto1_encontrado'] = $resultado['producto1_encontrado'];
        $_SESSION['producto2_encontrado'] = $resultado['producto2_encontrado'];
        
        require_once __DIR__ . '/../vista/resultado_personalizado.php';
    }
}

// Manejo de peticiones
if (isset($_GET['paso'])) {
    $comparador = new ComparadorPersonalizado();
    
    try {
        if ($_GET['paso'] == '2') {
            $comparador->mostrarFormulario();
        } elseif ($_GET['paso'] == '3') {
            $comparador->compararProductos();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>