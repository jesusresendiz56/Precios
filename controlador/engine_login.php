<?php
session_start();
require_once '../modelo/conexion.php'; // $conn debe ser un objeto MySQLi válido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que existan los campos requeridos
    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        // Sanitizar entradas
        $correo = trim($_POST['email']);
        $clave = $_POST['password'];

        // Buscar usuario en la base de datos
        $stmt = $conn->prepare("SELECT id_usuario, nombre_completo, clave FROM usuarios WHERE correo = ?");
        if (!$stmt) {
            die("Error en la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($clave, $usuario['clave'])) {
                // Guardar sesión del usuario
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre'] = $usuario['nombre_completo'];
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

        $stmt->close();
    } else {
        echo "⚠️ Por favor completa todos los campos.";
    }
}

$conn->close();
?>
