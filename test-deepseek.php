<?php
// test-final.php
echo "🚀 PRUEBA FINAL DEEPSEEK\n";
echo "=======================\n\n";

// Cargar controlador
require_once 'controlador/DeepSeekController.php';

$controller = new DeepSeekController();

echo "1. Probando conexión API...\n";
$resultado = $controller->consultar("Responde solo 'OK' si funciona");

if ($resultado['success']) {
    echo "✅ ✅ ✅ ¡FUNCIONA! ✅ ✅ ✅\n";
    echo "Respuesta: " . $resultado['respuesta'] . "\n";
    echo "Tokens: " . $resultado['tokens_usados'] . "\n\n";
    
    }else {
    echo "❌ Error: " . $resultado['error'] . "\n\n";
}

echo "\n🎯 PRUEBA TERMINADA\n";
?>