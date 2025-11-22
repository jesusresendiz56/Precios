<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

function enviarJSON($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

class ProductoScraper {

    private function obtenerArchivosJSON($tienda) {
        $patron = __DIR__ . "/../data/{$tienda}_*.json";
        return glob($patron) ?: [];
    }

    public function buscarEnTodasLasTiendas($termino) {
        return [
            'walmart'  => $this->scrapearWalmart($termino),
            'chedraui' => $this->scrapearChedraui($termino),
            'soriana'  => $this->scrapearSoriana($termino)
        ];
    }

    /* ================= SORIANA ================== */
    public function scrapearSoriana($termino) {
        $archivos = $this->obtenerArchivosJSON('soriana');
        if (empty($archivos)) return ['error' => 'No se encontraron archivos JSON de Soriana'];

        $productosFinal = [];
        $terminoLower = strtolower($termino);

        foreach ($archivos as $archivo) {

            $data = json_decode(file_get_contents($archivo), true);
            if (!$data) continue;

            $lista = isset($data['productos']) ? $data['productos'] : $data;

            foreach ($lista as $item) {

                if ($termino !== "" && stripos($item['nombre'], $terminoLower) === false)
                    continue;

                $precio = floatval($item['precio'] ?? 0);
                if ($precio <= 0) continue;

                $productosFinal[] = [
                    'nombre'       => $item['nombre'],
                    'precio'       => $precio,
                    'precio_antes' => $item['precio_antes'] ?? $precio,
                    'tienda'       => 'Soriana',
                    'imagen'       => $item['imagen'] ?? '',
                    'url'          => "https://www.soriana.com" . ($item['url'] ?? ""),
                    'marca'        => $this->extraerMarca($item['nombre']),
                    'categoria'    => $this->detectarCategoria($item['nombre']),
                    'rating'       => rand(40, 50) / 10,
                    'reviews'      => rand(10, 150)
                ];
            }
        }

        return ['productos' => $productosFinal];
    }

    /* ================= WALMART ================== */
    public function scrapearWalmart($termino) {
        $archivos = $this->obtenerArchivosJSON('walmart');
        if (empty($archivos)) return ['error' => 'No se encontraron archivos JSON de Walmart'];

        $productosFinal = [];
        $terminoLower = strtolower($termino);

        foreach ($archivos as $archivo) {
            $data = json_decode(file_get_contents($archivo), true);
            if (!$data || !isset($data['productos'])) continue;

            foreach ($data['productos'] as $item) {
                if ($termino !== "" && stripos($item['nombre'], $terminoLower) === false)
                    continue;

                $precio = floatval($item['precio'] ?? 0);
                if ($precio <= 0) continue;

                $productosFinal[] = [
                    'nombre'       => $item['nombre'],
                    'precio'       => $precio,
                    'precio_antes' => $precio * 1.10,
                    'tienda'       => 'Walmart',
                    'imagen'       => $item['imagen'] ?? '',
                    'url'          => $item['url'] ?? '#'
                ];
            }
        }

        return ['productos' => $productosFinal];
    }

    /* ================= CHEDRAUI ================== */
    public function scrapearChedraui($termino) {
        $archivos = $this->obtenerArchivosJSON('chedraui');
        if (empty($archivos)) return ['error' => 'No se encontraron archivos JSON de Chedraui'];

        $productosFinal = [];
        $terminoLower = strtolower($termino);

        foreach ($archivos as $archivo) {

            $data = json_decode(file_get_contents($archivo), true);
            if (!$data) continue;

            // Admite ambos formatos: con "productos" o lista directa
            $lista = isset($data['productos']) ? $data['productos'] : $data;

            foreach ($lista as $item) {

                if ($termino !== "" && stripos($item['nombre'], $terminoLower) === false)
                    continue;

                $precio = floatval($item['precio'] ?? 0);
                if ($precio <= 0) continue;

                $productosFinal[] = [
                    'nombre'       => $item['nombre'],
                    'precio'       => $precio,
                    'precio_antes' => $precio * 1.15,
                    'tienda'       => 'Chedraui',
                    'imagen'       => $item['imagen'] ?? '',
                    'url'          => $item['url'] ?? '#'
                ];
            }
        }

        return ['productos' => $productosFinal];
    }

    private function detectarCategoria($nombre) {
        $n = strtolower($nombre);
        if (strpos($n, "papel") !== false) return "Papel Higiénico";
        if (strpos($n, "toalla") !== false) return "Toallas de Papel";
        return "Otros";
    }

    private function extraerMarca($nombre) {
        $n = strtolower($nombre);
        $marcas = ['regio','petalo','cottonelle','kleenex','quality','suavel','precissimo','elite'];
        foreach ($marcas as $m) if (strpos($n, $m) !== false) return ucfirst($m);
        return "Genérico";
    }
}

/* ===== PETICIÓN POST ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar'])) {
    $termino = $_POST['termino'] ?? '';
    $scraper = new ProductoScraper();
    enviarJSON($scraper->buscarEnTodasLasTiendas($termino));
}

enviarJSON([
    'status' => 'ok',
    'msg' => 'Scraper funcionando correctamente'
]);
