<?php
session_start();
require_once '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        $correo = trim($_POST['email']);
        $clave = $_POST['password'];

        try {
            $manager = getMongoManager();
            $dbname = getMongoDB();

            // Buscar usuario en la base de datos
            $filter = ['correo' => $correo];
            $options = [];
            $query = new MongoDB\Driver\Query($filter, $options);
            $cursor = $manager->executeQuery("$dbname.usuarios", $query);
            $usuarios = iterator_to_array($cursor);

            if (count($usuarios) === 1) {
                $usuario = current($usuarios);
                
                // Verificar la contraseña
                if (password_verify($clave, $usuario->clave)) {
                    // Guardar sesión del usuario
                    $_SESSION['id_usuario'] = (string)$usuario->_id;
                    $_SESSION['nombre'] = $usuario->nombre_completo;
                    $_SESSION['correo'] = $correo;

                    // Redirigir al inicio o panel principal
                    header("Location: ../vista/verificacion2fa.php");
                    exit();
                } else {
                    echo "⚠️ Contraseña incorrecta.";
                }
            } else {
                echo "⚠️ No se encontró una cuenta con ese correo.";
            }
        } catch (Exception $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }

    } else {
        echo "⚠️ Por favor completa todos los campos.";
    }
}
?>