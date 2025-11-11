<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
        
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        
        try {
            $manager = getMongoManager();
            $dbname = getMongoDB();
            
            // Verificar contraseña actual
            $filter = ['_id' => new MongoDB\BSON\ObjectId($_SESSION['id_usuario'])];
            $options = [];
            $query = new MongoDB\Driver\Query($filter, $options);
            $cursor = $manager->executeQuery("$dbname.usuarios", $query);
            $usuarios = iterator_to_array($cursor);
            
            if (count($usuarios) === 1) {
                $usuario = current($usuarios);
                
                if (password_verify($current_password, $usuario->clave)) {
                    // Actualizar contraseña
                    $bulk = new MongoDB\Driver\BulkWrite;
                    $update = [
                        '$set' => [
                            'clave' => password_hash($new_password, PASSWORD_DEFAULT),
                            'fecha_actualizacion' => new MongoDB\BSON\UTCDateTime()
                        ]
                    ];
                    
                    $bulk->update($filter, $update);
                    $result = $manager->executeBulkWrite("$dbname.usuarios", $bulk);
                    
                    header("Location: perfil.php?password_success=1");
                    exit();
                } else {
                    header("Location: perfil.php?password_error=1");
                    exit();
                }
            }
            
        } catch (Exception $e) {
            header("Location: perfil.php?error=1");
            exit();
        }
    } else {
        header("Location: perfil.php?password_error=2");
        exit();
    }
} else {
    header("Location: perfil.php");
    exit();
}
?>