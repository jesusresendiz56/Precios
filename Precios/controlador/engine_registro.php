<?php
session_start();
require_once '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !empty($_POST['nombre']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['confirmPassword'])
    ) {

        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['email']);
        $clave = $_POST['password'];
        $confirmar = $_POST['confirmPassword'];

        if ($clave !== $confirmar) {
            echo "⚠️ Las contraseñas no coinciden.";
            exit();
        }

        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        try {
            $manager = getMongoManager();
            $dbname = getMongoDB();

            $filter = ['correo' => $correo];
            $options = [];
            $query = new MongoDB\Driver\Query($filter, $options);
            $cursor = $manager->executeQuery("$dbname.usuarios", $query);
            $usuarios = iterator_to_array($cursor);

            if (count($usuarios) > 0) {
                echo "⚠️ Este correo ya está registrado. Intenta con otro.";
                exit();
            }

            $bulk = new MongoDB\Driver\BulkWrite;
            $documento = [
                'nombre_completo' => $nombre,
                'correo' => $correo,
                'clave' => $claveHash,
                'fecha_registro' => new MongoDB\BSON\UTCDateTime()
            ];
            
            $bulk->insert($documento);
            $result = $manager->executeBulkWrite("$dbname.usuarios", $bulk);
            
            if ($result->getInsertedCount() === 1) {
                header("Location: ../vista/index.html?registro=exitoso");
                exit();
            } else {
                echo "Error al registrar usuario.";
            }
        } catch (Exception $e) {
            echo "Error al registrar usuario: " . $e->getMessage();
        }

    } else {
        echo "⚠️ Por favor completa todos los campos.";
    }
}
?>