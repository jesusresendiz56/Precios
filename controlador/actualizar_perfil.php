<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $manager = getMongoManager();
        $dbname = getMongoDB();
        
        $nombre_completo = trim($_POST['nombre_completo']);
        $telefono = trim($_POST['telefono']);
        $categorias_favoritas = isset($_POST['categorias_favoritas']) ? 
            array_map('trim', explode(',', $_POST['categorias_favoritas'])) : [];
        $notificaciones = isset($_POST['notificaciones']) ? true : false;
        
        // Actualizar documento del usuario
        $bulk = new MongoDB\Driver\BulkWrite;
        $filter = ['_id' => new MongoDB\BSON\ObjectId($_SESSION['id_usuario'])];
        
        $update = [
            '$set' => [
                'nombre_completo' => $nombre_completo,
                'telefono' => $telefono,
                'categorias_favoritas' => $categorias_favoritas,
                'notificaciones' => $notificaciones,
                'fecha_actualizacion' => new MongoDB\BSON\UTCDateTime()
            ]
        ];
        
        $bulk->update($filter, $update);
        $result = $manager->executeBulkWrite("$dbname.usuarios", $bulk);
        
        // Actualizar datos en sesión
        $_SESSION['nombre'] = $nombre_completo;
        
        header("Location: perfil.php?success=1");
        exit();
        
    } catch (Exception $e) {
        header("Location: perfil.php?error=1");
        exit();
    }
} else {
    header("Location: perfil.php");
    exit();
}
?>