<?php
session_start();
require_once '../modelo/conexion.php'; // $conn debe ser un objeto MySQLi válido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validar que los campos necesarios estén presentes
    if (
        !empty($_POST['nombre']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password']) &&
        !empty($_POST['confirmPassword'])
    ) {

        // Sanitizar entradas
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['email']);
        $clave = $_POST['password'];
        $confirmar = $_POST['confirmPassword'];

        // Verificar coincidencia de contraseñas
        if ($clave !== $confirmar) {
            echo "⚠️ Las contraseñas no coinciden.";
            exit();
        }

        // Encriptar la contraseña
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        // Comprobar si el correo ya existe
        $verificar = $conn->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
        $verificar->bind_param("s", $correo);
        $verificar->execute();
        $verificar->store_result();

        if ($verificar->num_rows > 0) {
            echo "⚠️ Este correo ya está registrado. Intenta con otro.";
            $verificar->close();
            exit();
        }
        $verificar->close();

        // Insertar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, correo, clave) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Error en la preparación: " . $conn->error);
        }

        $stmt->bind_param("sss", $nombre, $correo, $claveHash);

        if ($stmt->execute()) {
            header("Location: ../vista/login.html");
            exit();
        } else {
            echo "Error al registrar usuario: " . $stmt->error;
        }

        $stmt->close();

    } else {
        echo "⚠️ Por favor completa todos los campos.";
    }
}

$conn->close();
?>
