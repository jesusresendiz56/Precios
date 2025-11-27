<?php
session_start();

class ComparadorController {

    public function index() {
        require_once __DIR__ . "/../vista/comparador.php";
    }

    public function procesar() {

        $apiUrl = "https://api.deepseek.com/v1/chat/completions";
        $apiKey = "sk-db23a8d2d39f4fcb83e1af6e0b165878";

        // === Obtener datos del formulario ===
        $categoria = $_POST["categoria"] ?? "";
        $periodo = $_POST["periodo"] ?? "";

        if (!$categoria || !$periodo) {
            die("Error: Debes seleccionar una categoría y un periodo.");
        }

        // === Cargar archivos JSON automáticamente ===
        $walmartFile = __DIR__ . "/../scr/tiendas/data/walmart_" . $categoria . ".json";
        $chedrauiFile = __DIR__ . "/../scr/tiendas/data/chedraui_" . $categoria . ".json";

        if (!file_exists($walmartFile)) {
            die("
                <h3>Error: Archivo no encontrado</h3>
                <p><strong>Categoría:</strong> $categoria</p>
                <p><strong>Buscando en:</strong> $walmartFile</p>
                <p><strong>¿Existe?</strong> " . (file_exists($walmartFile) ? "SÍ" : "NO") . "</p>
                <hr>
                <p>Verifica que el archivo exista y se llame exactamente: <code>walmart_$categoria.json</code></p>
            ");
        }

        if (!file_exists($chedrauiFile)) {
            die("
                <h3>Error: Archivo no encontrado</h3>
                <p><strong>Categoría:</strong> $categoria</p>
                <p><strong>Buscando en:</strong> $chedrauiFile</p>
                <p><strong>¿Existe?</strong> " . (file_exists($chedrauiFile) ? "SÍ" : "NO") . "</p>
                <hr>
                <p>Verifica que el archivo exista y se llame exactamente: <code>chedraui_$categoria.json</code></p>
            ");
        }

        $walmart = file_get_contents($walmartFile);
        $chedraui = file_get_contents($chedrauiFile);

        // === Nombres amigables de categorías ===
        $nombresCategoria = [
            "arroz" => "Arroz",
            "papel" => "Papel",
            "refrescos" => "Refrescos",
            "galletas" => "Galletas",
            "lacteos" => "Lácteos"
        ];

        $nombreCategoria = $nombresCategoria[$categoria] ?? $categoria;

        // === Nombres amigables de periodos ===
        $nombresPeriodo = [
            "semanal" => "una semana",
            "quincenal" => "dos semanas",
            "mensual" => "un mes"
        ];

        $nombrePeriodo = $nombresPeriodo[$periodo] ?? $periodo;

        // === Prompt mejorado para comparación inteligente ===
        $prompt = "
Eres un asistente experto en comparación de precios de supermercados. 

El usuario quiere comprar productos de la categoría **$nombreCategoria** para **$nombrePeriodo**.

Tu tarea es:
1. Comparar TODOS los productos disponibles en Walmart vs Chedraui
2. Calcular cuál tienda ofrece mejor precio por producto
3. Considerar el tamaño/presentación (kg, g, litros, unidades, etc.)
4. Hacer una recomendación inteligente considerando:
   - ¿Qué tienda tiene mejores precios en general?
   - ¿Conviene comprar presentaciones más grandes para el periodo seleccionado?
   - ¿Hay productos donde una tienda es claramente mejor?

Devuelve SOLO un JSON con esta estructura exacta (sin texto adicional):

{
  \"categoria\": \"$nombreCategoria\",
  \"periodo\": \"$nombrePeriodo\",
  \"productos\": [
    {
      \"nombre\": \"nombre del producto\",
      \"walmart_precio\": 0,
      \"walmart_presentacion\": \"presentación\",
      \"chedraui_precio\": 0,
      \"chedraui_presentacion\": \"presentación\",
      \"mas_barato\": \"Walmart\" o \"Chedraui\",
      \"ahorro\": 0,
      \"ahorro_porcentaje\": 0
    }
  ],
  \"resumen\": {
    \"total_walmart\": 0,
    \"total_chedraui\": 0,
    \"tienda_ganadora\": \"Walmart\" o \"Chedraui\",
    \"ahorro_total\": 0,
    \"ahorro_porcentaje_total\": 0
  },
  \"recomendacion\": \"Texto con recomendación personalizada considerando el periodo de compra y los mejores productos de cada tienda\"
}

**Walmart JSON:**
$walmart

**Chedraui JSON:**
$chedraui

IMPORTANTE: Devuelve ÚNICAMENTE el JSON, sin texto antes ni después.
";

        // === Preparar petición a la API ===
        $data = [
            "model" => "deepseek-chat",
            "messages" => [
                ["role" => "user", "content" => $prompt]
            ],
            "temperature" => 0.2
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // === Validar respuesta ===
        if ($httpCode !== 200) {
            die("<h3>Error HTTP $httpCode</h3><pre>$response</pre>");
        }

        $responseData = json_decode($response, true);

        if (!$responseData) {
            die("<h3>Error: respuesta no válida</h3><pre>$response</pre>");
        }

        if (isset($responseData["error"])) {
            die("<h3>Error API:</h3><pre>" . print_r($responseData["error"], true) . "</pre>");
        }

        if (!isset($responseData["choices"][0]["message"]["content"])) {
            die("Error: la IA no devolvió contenido.");
        }

        // === Procesar JSON de la IA ===
        $raw = $responseData["choices"][0]["message"]["content"];
        $clean = preg_replace('/```json|```/', '', $raw);

        $resultado = json_decode(trim($clean), true);

        if (!$resultado) {
            die("<h3>Error: la IA no generó JSON válido</h3><pre>$raw</pre>");
        }

        // === Guardar datos para la vista ===
        $_SESSION['resultado_comparacion'] = $resultado;
        $_SESSION['categoria'] = $nombreCategoria;
        $_SESSION['periodo'] = $nombrePeriodo;

        // === Mostrar resultados ===
        require_once __DIR__ . "/../vista/resultadocom.php";
    }
}

// Ejecutar POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller = new ComparadorController();
    $controller->procesar();
}