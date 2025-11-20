<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

function enviarJSON($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

class ProductoScraper {
    private $archivoWalmart = 'data/walmart_papel.json';
    private $archivoChedraui = 'data/chedragui_papel.json';
    private $archivoSoriana = 'data/soriana_papel.json';
    private $eliminarDuplicados = false;

    public function scrapearWalmart($termino) {
        if (!file_exists($this->archivoWalmart)) {
            return ['error' => 'No se encontró walmart_papel.json'];
        }

        $json = file_get_contents($this->archivoWalmart);
        $data = json_decode($json, true);
        $resultado = $this->procesarJSONWalmart($data);

        return [
            'productos' => $resultado['productos'],
            'total_encontrados' => count($resultado['productos']),
            'total_en_json' => $resultado['total_en_json'],
            'sin_precio' => $resultado['sin_precio'],
            'duplicados_eliminados' => $resultado['duplicados'],
            'paginas_consultadas' => isset($data['search_results']) ? count($data['search_results']) : 0
        ];
    }

    public function scrapearChedraui($termino) {
        if (!file_exists($this->archivoChedraui)) {
            return ['error' => 'No se encontró chedragui_papel.json'];
        }

        $json = file_get_contents($this->archivoChedraui);
        $data = json_decode($json, true);
        
        if ($data === null) {
            return ['error' => 'Error al decodificar JSON de Chedraui'];
        }

        $resultado = $this->procesarJSONChedraui($data);

        return [
            'productos' => $resultado['productos'],
            'total_encontrados' => count($resultado['productos']),
            'total_en_json' => $resultado['total_en_json'],
            'sin_precio' => $resultado['sin_precio'],
            'duplicados_eliminados' => $resultado['duplicados']
        ];
    }

    public function scrapearSoriana($termino) {
        if (!file_exists($this->archivoSoriana)) {
            return ['error' => 'No se encontró soriana_papel.json'];
        }

        $json = file_get_contents($this->archivoSoriana);
        $data = json_decode($json, true);

        if ($data === null) {
            return ['error' => 'Error al decodificar JSON de Soriana'];
        }

        $productos = [];
        $total = 0;
        $sinPrecio = 0;

        // CORRECCIÓN: Los productos están directamente en $data, no en $data['productos']
        if (!is_array($data)) {
            return [
                'productos' => [], 
                'total_encontrados' => 0,
                'total_en_json' => 0, 
                'sin_precio' => 0,
                'duplicados_eliminados' => 0
            ];
        }

        foreach ($data as $item) {
            $total++;

            // Extraer el precio correctamente
            $precioString = isset($item['precio']) ? $item['precio'] : '';
            $precio = $this->extraerPrecio($precioString);
            
            if ($precio <= 0) {
                $sinPrecio++;
                continue;
            }

            // Extraer precio tachado si existe
            $precioAntes = 0;
            if (isset($item['precio_tachado']) && !empty($item['precio_tachado'])) {
                $precioAntes = $this->extraerPrecio($item['precio_tachado']);
            } else {
                $precioAntes = $precio * 1.1;
            }

            $productos[] = [
                'nombre' => $item['nombre'] ?? 'Sin nombre',
                'precio' => $precio,
                'precio_antes' => $precioAntes,
                'tienda' => 'Soriana',
                'categoria' => '🧻 Papel Higiénico',
                'marca' => '',
                'imagen' => $item['imagen'] ?? '',
                'url' => 'https://www.soriana.com' . ($item['href'] ?? ''),
                'rating' => rand(40, 50) / 10,
                'reviews' => rand(10, 150),
                'disponibilidad' => 'Disponible',
                'vendedor' => 'Soriana',
                'id' => 'soriana_' . $total
            ];
        }

        return [
            'productos' => $productos,
            'total_encontrados' => count($productos),
            'total_en_json' => $total,
            'sin_precio' => $sinPrecio,
            'duplicados_eliminados' => 0
        ];
    }

    private function extraerPrecio($precioString) {
        if (empty($precioString)) {
            return 0;
        }

        $precioString = trim($precioString);
        
        if (preg_match('/\\$?(\\d+\\.\\d+)/', $precioString, $matches)) {
            return floatval($matches[1]);
        }
        
        if (preg_match('/\\$?(\\d+)/', $precioString, $matches)) {
            return floatval($matches[1]);
        }
        
        return 0;
    }

    private function procesarJSONWalmart($data) {
        $productos = [];
        $productosUnicos = [];
        $totalEnJson = 0;
        $sinPrecio = 0;
        $duplicados = 0;

        if (!isset($data['search_results'])) {
            return [
                'productos' => [], 'total_en_json' => 0, 'sin_precio' => 0, 'duplicados' => 0
            ];
        }

        foreach ($data['search_results'] as $bloque) {
            if (!isset($bloque['item']) || !is_array($bloque['item'])) continue;

            foreach ($bloque['item'] as $item) {
                $totalEnJson++;
                $idProducto = isset($item['usItemId']) ? $item['usItemId'] : md5($item['title'] ?? $totalEnJson);
                if ($this->eliminarDuplicados && isset($productosUnicos[$idProducto])) { $duplicados++; continue; }

                $precioString = $item['current_price'] ?? '';
                $precio = $this->extraerPrecio($precioString);
                if ($precio <= 0) { $sinPrecio++; continue; }

                $producto = [
                    'nombre' => $item['title'] ?? 'Sin nombre',
                    'precio' => $precio,
                    'precio_antes' => isset($item['before_price']) ? $this->extraerPrecio($item['before_price']) : 0,
                    'tienda' => 'Walmart',
                    'categoria' => '🧻 Papel Higiénico',
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
            'productos' => $productos, 'total_en_json' => $totalEnJson, 'sin_precio' => $sinPrecio, 'duplicados' => $duplicados
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
            $categoria = '🧻 Papel Higiénico';

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

    public function buscarEnTodasLasTiendas($termino) {
        $walmart = $this->scrapearWalmart($termino);
        $chedraui = $this->scrapearChedraui($termino);
        $soriana = $this->scrapearSoriana($termino);

        return [
            'walmart' => $walmart['productos'],
            'walmart_info' => $walmart,
            'chedraui' => $chedraui['productos'],
            'chedraui_info' => $chedraui,
            'soriana' => $soriana['productos'],
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

enviarJSON(['status' => 'ok', 'message' => 'Scraper funcionando con JSON local - Ahora incluye Soriana']);
?>