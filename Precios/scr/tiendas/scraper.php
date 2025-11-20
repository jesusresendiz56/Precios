<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

function enviarJSON($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

class ProductoScraper {
    private $eliminarDuplicados = false;

    // Busca todos los archivos JSON de una tienda
    private function obtenerArchivosJSON($tienda) {
        $archivos = [];
        $patron = "data/{$tienda}_*.json";
        
        foreach (glob($patron) as $archivo) {
            if (file_exists($archivo)) {
                $archivos[] = $archivo;
            }
        }
        
        return $archivos;
    }

    public function scrapearWalmart($termino) {
        $archivos = $this->obtenerArchivosJSON('walmart');
        
        if (empty($archivos)) {
            return ['error' => 'No se encontraron archivos JSON de Walmart'];
        }

        $todosLosProductos = [];
        $totalEnJson = 0;
        $sinPrecio = 0;
        $duplicados = 0;
        $sinStock = 0;
        $archivosConsultados = 0;

        foreach ($archivos as $archivo) {
            $json = file_get_contents($archivo);
            $data = json_decode($json, true);
            
            if ($data === null) continue;
            
            $resultado = $this->procesarJSONWalmart($data, $termino);
            
            $todosLosProductos = array_merge($todosLosProductos, $resultado['productos']);
            $totalEnJson += $resultado['total_en_json'];
            $sinPrecio += $resultado['sin_precio'];
            $duplicados += $resultado['duplicados'];
            $sinStock += $resultado['sin_stock'];
            $archivosConsultados++;
        }

        return [
            'productos' => $todosLosProductos,
            'total_encontrados' => count($todosLosProductos),
            'total_en_json' => $totalEnJson,
            'sin_precio' => $sinPrecio,
            'duplicados_eliminados' => $duplicados,
            'sin_stock' => $sinStock,
            'archivos_consultados' => $archivosConsultados
        ];
    }

    public function scrapearChedraui($termino) {
        $archivos = $this->obtenerArchivosJSON('chedraui');
        
        if (empty($archivos)) {
            return ['error' => 'No se encontraron archivos JSON de Chedraui'];
        }

        $todosLosProductos = [];
        $totalEnJson = 0;
        $sinPrecio = 0;
        $duplicados = 0;

        foreach ($archivos as $archivo) {
            $json = file_get_contents($archivo);
            $data = json_decode($json, true);
            
            if ($data === null) continue;
            
            $resultado = $this->procesarJSONChedraui($data);
            
            $todosLosProductos = array_merge($todosLosProductos, $resultado['productos']);
            $totalEnJson += $resultado['total_en_json'];
            $sinPrecio += $resultado['sin_precio'];
            $duplicados += $resultado['duplicados'];
        }

        return [
            'productos' => $todosLosProductos,
            'total_encontrados' => count($todosLosProductos),
            'total_en_json' => $totalEnJson,
            'sin_precio' => $sinPrecio,
            'duplicados_eliminados' => $duplicados
        ];
    }

    public function scrapearSoriana($termino) {
        $archivos = $this->obtenerArchivosJSON('soriana');
        
        if (empty($archivos)) {
            return ['error' => 'No se encontraron archivos JSON de Soriana'];
        }

        $todosLosProductos = [];
        $totalEnJson = 0;
        $sinPrecio = 0;

        foreach ($archivos as $archivo) {
            $json = file_get_contents($archivo);
            $data = json_decode($json, true);
            
            if ($data === null || !is_array($data)) continue;

            foreach ($data as $item) {
                $totalEnJson++;

                $precioString = isset($item['precio']) ? $item['precio'] : '';
                $precio = $this->extraerPrecio($precioString);
                
                if ($precio <= 0) {
                    $sinPrecio++;
                    continue;
                }

                $precioAntes = 0;
                if (isset($item['precio_tachado']) && !empty($item['precio_tachado'])) {
                    $precioAntes = $this->extraerPrecio($item['precio_tachado']);
                } else {
                    $precioAntes = $precio * 1.1;
                }

                $todosLosProductos[] = [
                    'nombre' => $item['nombre'] ?? 'Sin nombre',
                    'precio' => $precio,
                    'precio_antes' => $precioAntes,
                    'tienda' => 'Soriana',
                    'categoria' => $this->detectarCategoria($item['nombre'] ?? ''),
                    'marca' => '',
                    'imagen' => $item['imagen'] ?? '',
                    'url' => 'https://www.soriana.com' . ($item['href'] ?? ''),
                    'rating' => rand(40, 50) / 10,
                    'reviews' => rand(10, 150),
                    'disponibilidad' => 'Disponible',
                    'vendedor' => 'Soriana',
                    'id' => 'soriana_' . $totalEnJson
                ];
            }
        }

        return [
            'productos' => $todosLosProductos,
            'total_encontrados' => count($todosLosProductos),
            'total_en_json' => $totalEnJson,
            'sin_precio' => $sinPrecio,
            'duplicados_eliminados' => 0
        ];
    }

    private function detectarCategoria($nombre) {
        $nombre = strtolower($nombre);
        
        if (strpos($nombre, 'papel') !== false || strpos($nombre, 'higienico') !== false) {
            return '🧻 Papel Higiénico';
        }
        if (strpos($nombre, 'refresco') !== false || strpos($nombre, 'coca') !== false || strpos($nombre, 'pepsi') !== false) {
            return '🥤 Refrescos';
        }
        if (strpos($nombre, 'leche') !== false || strpos($nombre, 'yogurt') !== false) {
            return '🥛 Lácteos';
        }
        
        return '🛒 Otros Productos';
    }

    private function extraerPrecio($precioString) {
        if (empty($precioString)) {
            return 0;
        }

        $precioString = trim($precioString);
        
        if (preg_match('/\$?(\d+\.\d+)/', $precioString, $matches)) {
            return floatval($matches[1]);
        }
        
        if (preg_match('/\$?(\d+)/', $precioString, $matches)) {
            return floatval($matches[1]);
        }
        
        return 0;
    }

    private function procesarJSONWalmart($data, $termino = '') {
        $productos = [];
        $productosUnicos = [];
        $totalEnJson = 0;
        $sinPrecio = 0;
        $duplicados = 0;
        $sinStock = 0;

        if (!isset($data['search_results'])) {
            return [
                'productos' => [], 'total_en_json' => 0, 'sin_precio' => 0, 'duplicados' => 0, 'sin_stock' => 0
            ];
        }

        foreach ($data['search_results'] as $bloque) {
            if (!isset($bloque['item']) || !is_array($bloque['item'])) continue;

            foreach ($bloque['item'] as $item) {
                $totalEnJson++;
                
                // FILTRADO MEJORADO - Verificar disponibilidad
                $disponibilidad = strtolower($item['availability_status'] ?? '');
                $estadosNoDisponibles = [
                    'out of stock',
                    'no disponible', 
                    'agotado',
                    'sin stock',
                    'no hay stock'
                ];
                
                $estaDisponible = true;
                foreach ($estadosNoDisponibles as $estado) {
                    if (strpos($disponibilidad, $estado) !== false) {
                        $sinStock++;
                        $estaDisponible = false;
                        break;
                    }
                }
                
                if (!$estaDisponible) {
                    continue; // Saltar productos sin stock
                }
                
                // Filtrar por término de búsqueda
                $nombre = $item['title'] ?? '';
                $marca = $item['brand'] ?? '';
                if (!empty($termino) && !$this->coincideTermino($nombre . ' ' . $marca, $termino)) {
                    continue;
                }
                
                $idProducto = isset($item['usItemId']) ? $item['usItemId'] : md5($item['title'] ?? $totalEnJson);
                if ($this->eliminarDuplicados && isset($productosUnicos[$idProducto])) { $duplicados++; continue; }

                $precioString = $item['current_price'] ?? '';
                $precio = $this->extraerPrecio($precioString);
                if ($precio <= 0) { $sinPrecio++; continue; }

                $categoria = $this->detectarCategoria($item['title'] ?? '');

                $producto = [
                    'nombre' => $item['title'] ?? 'Sin nombre',
                    'precio' => $precio,
                    'precio_antes' => isset($item['before_price']) ? $this->extraerPrecio($item['before_price']) : 0,
                    'tienda' => 'Walmart',
                    'categoria' => $categoria,
                    'marca' => $item['brand'] ?? '',
                    'imagen' => $item['thumbnail'] ?? '',
                    'url' => 'https://www.walmart.com.mx' . ($item['canonicalUrl'] ?? ''),
                    'rating' => $item['rating'] ?? null,
                    'reviews' => $item['review_count'] ?? 0,
                    'disponibilidad' => $item['availability_status'] ?? '',
                    'vendedor' => $item['seller_name'] ?? 'Walmart',
                    'id' => $item['id'] ?? ''
                ];
                $productos[] = $producto;
                if ($this->eliminarDuplicados) $productosUnicos[$idProducto] = true;
            }
        }

        return [
            'productos' => $productos, 
            'total_en_json' => $totalEnJson, 
            'sin_precio' => $sinPrecio, 
            'duplicados' => $duplicados,
            'sin_stock' => $sinStock
        ];
    }

    private function procesarJSONChedraui($data) {
        $productos = [];
        $productosUnicos = [];
        $totalEnJson = 0;
        $sinPrecio = 0;
        $duplicados = 0;

        if (!isset($data['productos']) || !is_array($data['productos'])) {
            return ['productos' => [], 'total_en_json' => 0, 'sin_precio' => 0, 'duplicados' => 0];
        }

        foreach ($data['productos'] as $item) {
            $totalEnJson++;
            $idProducto = $item['sku'] ?? 'id_' . $totalEnJson;
            if ($this->eliminarDuplicados && isset($productosUnicos[$idProducto])) { $duplicados++; continue; }

            $precio = isset($item['precio']) ? floatval($item['precio']) : 0;
            if ($precio <= 0) { $sinPrecio++; continue; }

            $precioAntes = isset($item['precio_anterior']) && $item['precio_anterior'] ? floatval($item['precio_anterior']) : $precio * 1.15;
            $marca = $item['marca'] ?? '';
            $categoria = $this->detectarCategoria($item['nombre'] ?? '');

            $producto = [
                'nombre' => $item['nombre'] ?? 'Sin nombre',
                'precio' => $precio,
                'precio_antes' => $precioAntes,
                'tienda' => 'Chedraui',
                'categoria' => $categoria,
                'marca' => $marca,
                'imagen' => $item['imagen'] ?? '',
                'url' => $item['url_producto'] ?? '',
                'rating' => rand(40, 50) / 10,
                'reviews' => rand(50, 300),
                'disponibilidad' => $item['disponibilidad'] ?? 'Disponible',
                'vendedor' => 'Chedraui',
                'id' => $idProducto
            ];
            $productos[] = $producto;
            if ($this->eliminarDuplicados) $productosUnicos[$idProducto] = true;
        }

        return ['productos' => $productos, 'total_en_json' => $totalEnJson, 'sin_precio' => $sinPrecio, 'duplicados' => $duplicados];
    }

    private function coincideTermino($texto, $termino) {
        return stripos($texto, $termino) !== false;
    }

    public function buscarEnTodasLasTiendas($termino) {
        $walmart = $this->scrapearWalmart($termino);
        $chedraui = $this->scrapearChedraui($termino);
        $soriana = $this->scrapearSoriana($termino);

        return [
            'walmart' => $walmart['productos'] ?? [],
            'walmart_info' => $walmart,
            'chedraui' => $chedraui['productos'] ?? [],
            'chedraui_info' => $chedraui,
            'soriana' => $soriana['productos'] ?? [],
            'soriana_info' => $soriana
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar'])) {
    $termino = $_POST['termino'] ?? '';
    if (empty($termino)) enviarJSON(['error' => 'Debes ingresar un término']);
    $scraper = new ProductoScraper();
    enviarJSON($scraper->buscarEnTodasLasTiendas($termino));
}

enviarJSON(['status' => 'ok', 'message' => 'Scraper multi-archivo funcionando - Busca todos los JSON disponibles']);
?>